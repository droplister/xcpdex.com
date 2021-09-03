<?php

namespace App\Http\Controllers;

use Cache;
use Curl\Curl;
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
            ->where('xcp_core_quote_asset', '!=', 'BTC')
            ->where('volume', '>', 0)
            ->where('moderated', false)
            ->groupBy('xcp_core_quote_asset')
            ->orderBy('count', 'desc')
            ->orderBy('xcp_core_quote_asset')
            ->take(5)
            ->get();
        });

        // Market Data
        $data = Cache::remember('market_index_' . $quote_asset, 1440, function () use ($quote_asset) {
            $query = Market::where('xcp_core_quote_asset', $quote_asset)
            ->where('volume', '>', 0)
            ->orWhere('xcp_core_quote_asset', $quote_asset)
            ->where('open_orders_count', '>', 0);

            return [
                'trading_pairs' => $query->count(),
                'get_orders' => $query->sum('get_orders_count'),
                'give_orders' => $query->sum('give_orders_count'),
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

        // Digirare Card Asset
        $card = Cache::remember($market->base_asset_display_name . 'card', 1440, function () use ($market) {

            $curl = new Curl();
            $curl->setUserAgent('XCPDEX.com');
            $curl->get('https://digirare.com/api/widget/' . $market->baseAsset->asset_name);

            if ($curl->error) {
                return null;
            } else {
                $response = json_decode($curl->response);

                return [
                    'name' => $response->data->name,
                    'url' => 'https://digirare.com/cards/' . $response->data->name,
                    'img_url' => 'https://digirare.com' . $response->data->image,
                    'collection' => $response->data->collections[0]->name,
                    'collection_url' => 'https://digirare.com/browse?collection=' . $response->data->collections[0]->slug,
                    'meta' => $response->data->collections[0]->slug === 'rare-pepe' && isset($response->data->meta->series) ? 'Series ' . $response->data->meta->series : '',
                    'date' => $response->data->date,
                ];
            }
        });

        // Show View
        return view('markets.show', compact('market', 'last_match', 'card'));
    }
}