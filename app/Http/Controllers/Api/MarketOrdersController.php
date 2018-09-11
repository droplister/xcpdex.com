<?php

namespace App\Http\Controllers\Api;

use App\Market;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\Order;
use App\Http\Resources\AssetResource;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Market $market)
    {
        // Current Block Index
        $block = Block::latest('block_index')->first();

        // Cache Slug
        $cache_slug = 'api_market_orders_buys_' . $block->block_index . '_' . $market->slug;

        // Market's Buy Orders
        $buy_orders = Cache::remember($cache_slug, 5, function () use ($block, $market) {
            return Order::where('get_asset', '=', $market->xcp_core_base_asset)
            ->where('give_asset', '=', $market->xcp_core_quote_asset)
            ->where('expire_index', '>', $block->block_index)
            ->where('status', '=', 'open')
            ->get()
            ->sortByDesc('trading_price_normalized');
        });

        // Cache Slug
        $cache_slug = 'api_market_orders_sells_' . $block->block_index . '_' . $market->slug;

        // Market's Sell Orders
        $sell_orders = Cache::remember($cache_slug, 5, function () use ($block, $market) {
            return Order::where('give_asset', '=', $market->xcp_core_base_asset)
            ->where('get_asset', '=', $market->xcp_core_quote_asset)
            ->where('expire_index', '>', $block->block_index)
            ->where('status', '=', 'open')
            ->get()
            ->sortBy('trading_price_normalized');
        });

        return [
            'base_asset' => new AssetResource($market->baseAsset),
            'quote_asset' => new AssetResource($market->quoteAsset),
            'buy_orders' => OrderResource::collection($buy_orders),
            'sell_orders' => OrderResource::collection($sell_orders),
        ];
    }
}