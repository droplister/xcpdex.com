<?php

namespace App\Http\Controllers\Api;

use App\Market;
use Droplister\XcpCore\App\OrderMatch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketTradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Market $market)
    {
        // Market's Trade History
        $trade_history = OrderMatch::where('backward_asset', '=', $market->xcp_core_base_asset)
            ->where('forward_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->orWhere('backward_asset', '=', $market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $market->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->orderBy('tx_index', 'desc')
            ->paginate(30);

        return $trade_history;
    }
}