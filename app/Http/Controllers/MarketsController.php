<?php

namespace App\Http\Controllers;

use App\Market;
use Droplister\XcpCore\App\OrderMatch;
use Illuminate\Http\Request;

class MarketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $quote_asset
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $quote_asset='XCP')
    {
        // Markets
        $markets = Market::where('volume', '>', 0)
            ->selectRaw('COUNT(*) as count, xcp_core_quote_asset')
            ->groupBy('xcp_core_quote_asset')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        return view('markets.index', compact('markets', 'quote_asset'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Market $market)
    {
        // Market's Last Match
        $last_match = OrderMatch::where('backward_asset', '=', $market->xcp_core_base_asset)
            ->where('forward_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->orWhere('backward_asset', '=', $market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $market->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->orderBy('tx1_index', 'desc')
            ->first();

        return view('markets.show', compact('market', 'last_match'));
    }
}