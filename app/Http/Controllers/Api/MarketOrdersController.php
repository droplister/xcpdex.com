<?php

namespace App\Http\Controllers\Api;

use Cache;
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
        // Block Index
        $block_index = Cache::get('block_index') ? Cache::get('block_index') : Block::latest('block_index')->first()->block_index;

        // Cache Slug
        $cache_slug = 'api_market_orders_index_' . $block_index . '_' . $market->slug;

        // Market Orders
        return Cache::remember($cache_slug, 1440, function () use ($block_index, $market) {
            // Buy Orders
            $buy_orders =  Order::where('get_asset', '=', $market->xcp_core_base_asset)
                ->where('give_asset', '=', $market->xcp_core_quote_asset)
                ->where('expire_index', '>', $block_index)
                ->where('give_remaining', '>', 0)
                ->where('get_remaining', '>', 0)
                ->where('status', '=', 'open')
                ->get()
                ->sortByDesc('trading_price_normalized');

            // Sell Orders
            $sell_orders = Order::where('give_asset', '=', $market->xcp_core_base_asset)
                ->where('get_asset', '=', $market->xcp_core_quote_asset)
                ->where('expire_index', '>', $block->block_index)
                ->where('give_remaining', '>', 0)
                ->where('get_remaining', '>', 0)
                ->where('status', '=', 'open')
                ->get()
                ->sortBy('trading_price_normalized');

            return [
                'base_asset' => new AssetResource($market->baseAsset),
                'quote_asset' => new AssetResource($market->quoteAsset),
                'buy_orders' => OrderResource::collection($buy_orders),
                'sell_orders' => OrderResource::collection($sell_orders),
            ];
        });
    }
}