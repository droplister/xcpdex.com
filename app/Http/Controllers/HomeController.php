<?php

namespace App\Http\Controllers;

use App\Feature;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\Order;
use Droplister\XcpCore\App\OrderMatch;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Last Block
        $block = Block::latest('block_index')->first();

        // Last 24h
        $start_date = $block->confirmed_at->subHours(24)->toDateTimeString();
        $end_date = $block->confirmed_at->toDateTimeString();

        // Features
        $features = Feature::highestBids()->with('market')->get();

        // Orders #
        $orders_count = Order::whereBetween('confirmed_at', [$start_date, $end_date])->count();

        // Trades #
        $trades_count = OrderMatch::whereBetween('confirmed_at', [$start_date, $end_date])->count();

        // Index View
        return view('home.index', compact('features', 'orders_count', 'trades_count'));
    }
}