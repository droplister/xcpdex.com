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
        $markets = Market::with('quoteAsset')
            ->selectRaw('COUNT(*) as count, xcp_core_quote_asset')
            ->where('xcp_core_quote_asset', '!=', 'XCP')
            ->where('volume', '>', 0)
            ->groupBy('xcp_core_quote_asset')
            ->orderBy('count', 'desc')
            ->orderBy('xcp_core_quote_asset')
            ->take(10)
            ->get();

        // Index View
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
        $last_match = $market->lastMatch();

        // Show View
        return view('markets.show', compact('market', 'last_match'));
    }
}