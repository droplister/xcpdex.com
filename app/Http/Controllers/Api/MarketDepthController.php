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
        // Block Index
        $block_index = Cache::get('block_index');

        // Cache Slug
        $cache_slug = 'api_market_depth_' . $block_index . '_' . $market->slug;

        // Market Depth
        return Cache::remember($cache_slug, 1440, function () use ($block_index, $market) {
            // Market's Buy Orders
            $buy_orders = Order::where('get_asset', '=', $market->xcp_core_base_asset)
                ->where('give_asset', '=', $market->xcp_core_quote_asset)
                ->where('expire_index', '>', $block_index)
                ->where('give_remaining', '>', 0)
                ->where('get_remaining', '>', 0)
                ->where('status', '=', 'open')
                ->get()
                ->sortByDesc('trading_price_normalized');

            // Market's Sell Orders
            $sell_orders = Order::where('give_asset', '=', $market->xcp_core_base_asset)
                ->where('get_asset', '=', $market->xcp_core_quote_asset)
                ->where('expire_index', '>', $block_index)
                ->where('give_remaining', '>', 0)
                ->where('get_remaining', '>', 0)
                ->where('status', '=', 'open')
                ->get()
                ->sortBy('trading_price_normalized');

            return [
                'buy_orders' => DepthResource::collection($buy_orders),
                'sell_orders' => DepthResource::collection($sell_orders),
            ];
        });
    }
}