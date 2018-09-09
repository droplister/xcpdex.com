<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Market;
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
        $markets = Market::where('xcp_core_quote_asset', '=', $request->input('quote_asset', 'XCP'))
            ->orderBy('volume', 'desc')
            ->paginate(30);

        return [
            'markets' => MarketResource::collection($markets),
            'last_page' => ceil($markets->total() / 30),
            'current_page' => (int) $request->input('page', 1),
        ];
    }
}