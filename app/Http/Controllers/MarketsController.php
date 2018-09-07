<?php

namespace App\Http\Controllers;

use App\Market;
use Illuminate\Http\Request;

class MarketsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Market $market)
    {
        return view('markets.show', compact('market'));
    }
}