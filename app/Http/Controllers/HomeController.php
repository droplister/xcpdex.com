<?php

namespace App\Http\Controllers;

use Cache;
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
        // Price Data
        $price_data = $this->getPriceData();

        // Get Dates
        $dates = $this->getDates();

        // Orders #
        $order_counts = Cache::remember('order_counts_' . str_slug(serialize($dates)), 60, function () use ($dates) {
            return $this->getOrderCounts($dates);
        });

        // Features
        $features = Feature::highestBids()->with('market')->get();

        // Index View
        return view('home.index', compact('price_data', 'order_counts', 'features'));
    }

    /**
     * Get Dates
     * 
     * @return array
     */
    private function getDates()
    {
        // Last Block
        $block = Block::latest('block_index')->first();

        // The Dates
        $end_date = $block->confirmed_at->toDateTimeString();
        $start_date_recent = $block->confirmed_at->subHours(24)->toDateTimeString();
        $start_date_thirty = $block->confirmed_at->subDays(30)->toDateTimeString();
        $start_date_annual = $block->confirmed_at->subDays(365)->toDateTimeString();

        return [
            'end_date' => $end_date,
            'start_dates' => [
                'recent' => $start_date_recent,
                'thirty' => $start_date_thirty,
                'annual' => $start_date_annual,
            ],
        ];
    }

    /**
     * Get Order Counts
     * 
     * @param  array  $dates
     * @return array
     */
    private function getOrderCounts($dates)
    {
        $orders_count = Order::count();
        $r_orders_count = Order::whereBetween('confirmed_at', [$dates['start_dates']['recent'], $dates['end_date']])->count();
        $t_orders_count = Order::whereBetween('confirmed_at', [$dates['start_dates']['thirty'], $dates['end_date']])->count();
        $a_orders_count = Order::whereBetween('confirmed_at', [$dates['start_dates']['annual'], $dates['end_date']])->count();

        return [
            'all' => $orders_count,
            'recent' => $r_orders_count,
            'thirty' => $t_orders_count,
            'annual' => $a_orders_count,
        ];
    }

    /**
     * Get Price Data
     * 
     * @return array
     */
    private function getPriceData()
    {
        return Cache::remember('api_price_data', 10, function () {
            return [
                'price_btc' => number_format(1,1),
                'price_usd' => '$' . number_format(1,1),
                'volume' => '$' . number_format(1,1),
                'market_cap' => '$' . number_format(1,1),
            ];
        });
    }
}