<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Market;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\Order;
use App\Http\Resources\DepthResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketDepthController extends Controller
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
        $cache_slug = 'api_market_depth_buys_' . $block->block_index . '_' . $market->slug;

        // Market's Buy Orders
        $buy_orders = Cache::remember($cache_slug, 5, function () use ($block, $market) {
            return Order::where('get_asset', '=', $market->xcp_core_base_asset)
                ->where('give_asset', '=', $market->xcp_core_quote_asset)
                ->where('status', '=', 'open')
                ->where('expire_index', '>', $block->block_index)
                ->get()
                ->sortByDesc('trading_price_normalized');
        });

        // Cache Slug
        $cache_slug = 'api_market_depth_sells_' . $block->block_index . '_' . $market->slug;

        // Market's Sell Orders
        $sell_orders = Cache::remember($cache_slug, 5, function () use ($block, $market) {
            return Order::where('give_asset', '=', $market->xcp_core_base_asset)
            ->where('get_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'open')
            ->where('expire_index', '>', $block->block_index)
            ->get()
            ->sortBy('trading_price_normalized');
        });

        return [
            'buy_orders' => DepthResource::collection($buy_orders),
            'sell_orders' => DepthResource::collection($sell_orders),
        ];
    }
}