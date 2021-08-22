<?php

namespace App\Http\Controllers;

use App\Market;
use Droplister\XcpCore\App\Asset;
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
        // Index View
        return view('markets.index', compact('request', 'quote_asset'));
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