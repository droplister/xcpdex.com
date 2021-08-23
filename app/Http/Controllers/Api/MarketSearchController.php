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

        // Trim Query
        $query = trim($request->q);

        // Cache Slug
        $cache_slug = 'api_search_' . str_slug($query);

        // Get Markets
        return Cache::remember($cache_slug, 1440, function () use ($query) {
            // Top 10
            $markets = Market::where('xcp_core_base_asset', 'like', $query . '%')
                ->orWhere('xcp_core_quote_asset', 'like', $query . '%')
                ->orWhere('name', 'like', $query . '%')
                ->orderBy('volume', 'desc')
                ->take(10)
                ->get();

            return MarketResource::collection($markets);
        });
    }
}