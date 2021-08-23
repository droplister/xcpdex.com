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
        return Cache::remember($cache_slug, 1440, function () use ($request) {
            // Get Markets
            $markets = Market::where('xcp_core_quote_asset', '=', $request->input('quote_asset', 'XCP'))
                ->where('volume', '>', 0)
                ->orderBy('volume', 'desc')
                ->paginate(30);

            return [
                'markets' => MarketResource::collection($markets),
                'last_page' => ceil($markets->total() / 30),
                'current_page' => (int) $request->input('page', 1),
            ];
        });
    }
}