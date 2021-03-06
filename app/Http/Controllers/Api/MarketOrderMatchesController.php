<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Market;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\OrderMatch;
use App\Http\Resources\OrderMatchResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketOrderMatchesController extends Controller
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
        $cache_slug = 'api_market_order_matches_' . $block_index . '_' . $market->slug . '_' . str_slug(serialize($request->all()));

        // Market's Trade History
        return Cache::remember($cache_slug, 1440, function () use ($market, $request) {
            $order_matches = OrderMatch::where('backward_asset', '=', $market->xcp_core_base_asset)
                ->where('forward_asset', '=', $market->xcp_core_quote_asset)
                ->where('status', '=', 'completed')
                ->orWhere('backward_asset', '=', $market->xcp_core_quote_asset)
                ->where('forward_asset', '=', $market->xcp_core_base_asset)
                ->where('status', '=', 'completed')
                ->orderBy('tx1_index', 'desc')
                ->paginate(30);

            return [
                'order_matches' => OrderMatchResource::collection($order_matches),
                'last_page' => ceil($order_matches->total() / 30),
                'current_page' => (int) $request->input('page', 1),
            ];
        });
    }
}