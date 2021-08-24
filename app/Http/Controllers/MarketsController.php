<?php

namespace App\Http\Controllers;

use Cache;
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
        // Markets
        $markets = Cache::remember('market_index', 1440, function () {
            return Market::with('quoteAsset')
            ->selectRaw('COUNT(*) as count, xcp_core_quote_asset')
            ->where('xcp_core_quote_asset', '!=', 'XCP')
            ->where('volume', '>', 0)
            ->groupBy('xcp_core_quote_asset')
            ->orderBy('count', 'desc')
            ->orderBy('xcp_core_quote_asset')
            ->take(5)
            ->get();
        });

        // Market Data
        $data = Cache::remember('market_index_' . $quote_asset, 1440, function () use ($quote_asset) {
            $query = Market::where('xcp_core_quote_asset', $quote_asset)->where('volume', '>', 0);

            return [
                'trading_pairs' => $query->count(),
                'open_orders' => $query->sum('open_orders_count'),
                'volume_90d' => $query->sum('volume'),
            ];
        });

        // Index View
        return view('markets.index', compact('request', 'markets', 'data', 'quote_asset'));
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