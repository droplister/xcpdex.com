<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Market;
use App\Http\Resources\MarketResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketSearchController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validation
        $request->validate(['q' => 'required']);

        // Cache Slug
        $cache_slug = 'api_search_' . str_slug(serialize($request->all()));

        // Get Markets
        return Cache::remember($cache_slug, 1440, function () use ($request) {
            // Top 10
            $markets = Market::where('xcp_core_base_asset', 'like', $request->q . '%')
                ->orWhere('xcp_core_quote_asset', 'like', $request->q . '%')
                ->orWhere('name', 'like', $request->q . '%')
                ->orderBy('volume', 'desc')
                ->take(10)
                ->get();

            return MarketResource::collection($markets);
        });
    }
}