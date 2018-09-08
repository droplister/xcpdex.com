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
        $request->validate([
            'q' => 'required',
        ]);

        $query = strtolower($request->q);

        $markets = Cache::remember('api_search_' . $query, 360, function () use ($request) {
            return Market::where('xcp_core_base_asset', 'like', $request->q . '%')
                ->orWhere('xcp_core_quote_asset', 'like', $request->q . '%')
                ->orWhere('name', 'like', $request->q . '%')
                ->take(10)
                ->get();
        });

        return MarketResource::collection($markets);
    }
}