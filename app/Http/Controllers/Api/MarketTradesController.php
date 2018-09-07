<?php

namespace App\Http\Controllers\Api;

use App\Market;
use Droplister\XcpCore\App\OrderMatch;
use App\Http\Resources\AssetResource;
use App\Http\Resources\OrderMatchResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketTradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Market $market)
    {
        // Market's Trade History
        $order_matches = OrderMatch::where('backward_asset', '=', $market->xcp_core_base_asset)
            ->where('forward_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->orWhere('backward_asset', '=', $market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $market->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->orderBy('tx1_index', 'desc')
            ->paginate(30);

        return [
            'base_asset' => new AssetResource($market->baseAsset),
            'quote_asset' => new AssetResource($market->quoteAsset),
            'all_trades' => OrderMatchResource::collection($order_matches),
        ];
    }
}