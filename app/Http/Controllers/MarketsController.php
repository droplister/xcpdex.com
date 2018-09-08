<?php

namespace App\Http\Controllers;

use App\Market;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\Order;
use Droplister\XcpCore\App\OrderMatch;
use Illuminate\Http\Request;

class MarketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('markets.index');
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
        // Current Block Index
        $block = Block::latest('block_index')->first();

        // Market's Buy Orders
        $buy_orders = Order::where('get_asset', '=', $market->xcp_core_base_asset)
            ->where('give_asset', '=', $market->xcp_core_quote_asset)
            ->where('expire_index', '>', $block->block_index)
            ->where('status', '=', 'open')
            ->count();

        // Market's Sell Orders
        $sell_orders = Order::where('give_asset', '=', $market->xcp_core_base_asset)
            ->where('get_asset', '=', $market->xcp_core_quote_asset)
            ->where('expire_index', '>', $block->block_index)
            ->where('status', '=', 'open')
            ->count();

        // Market's Last Match
        $last_match = OrderMatch::where('backward_asset', '=', $market->xcp_core_base_asset)
            ->where('forward_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->orWhere('backward_asset', '=', $market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $market->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->orderBy('tx1_index', 'desc')
            ->first();

        return view('markets.show', compact('market', 'buy_orders', 'sell_orders', 'last_match'));
    }
}