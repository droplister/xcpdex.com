<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Market;
use Droplister\XcpCore\App\Block;
use App\Http\Resources\MarketResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Block Index
        $block_index = Cache::get('block_index') ? Cache::get('block_index') : Block::latest('block_index')->first()->block_index;

        // Cache Slug
        $cache_slug = 'api_markets_index_' . $block_index . '_' . str_slug(serialize($request->all()));

        // DEX Markets
        return Cache::remember($cache_slug, 30, function () use ($request) {
            if (in_array($request->sort_by, [
                'base_asset_supply',
                'orders_count',
                'get_orders_count',
                'give_orders_count',
                'order_matches_count',
                'market_cap',
                'volume'
            ])) {
                $order_by = $request->sort_by;
            } else {
                $order_by = 'volume';
            }

            // Get Markets
            $markets = Market::where('xcp_core_quote_asset', '=', $request->input('quote_asset', 'XCP'))
                ->where('volume', '>', 0)
                ->orWhere('xcp_core_quote_asset', '=', $request->input('quote_asset', 'XCP'))
                ->where('open_orders_count', '>', 0)
                ->orderBy($order_by, 'desc')
                ->paginate(30);

            return [
                'markets' => MarketResource::collection($markets),
                'last_page' => ceil($markets->total() / 30),
                'current_page' => (int) $request->input('page', 1),
            ];
        });
    }
}