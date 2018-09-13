<?php

namespace App\Http\Controllers;

use App\Market;
use App\Feature;
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

        // Features
        $features = Feature::highestBids()->with('market')->get();

        // Index View
        return view('markets.index', compact('markets', 'quote_asset', 'features'));
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

        // Features
        $features = Feature::highestBids()->with('market')->get();

        return view('markets.show', compact('market', 'last_match', 'features'));
    }
}