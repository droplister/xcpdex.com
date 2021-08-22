<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disclaimer(Request $request)
    {
        return view('pages.disclaimer');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function privacy(Request $request)
    {
        return view('pages.privacy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stats(Request $request)
    {
        // Get Dates
        $dates = $this->getDates();

        // Orders #
        $order_counts = Cache::remember('order_counts_' . str_slug(serialize($dates)), 60, function () use ($dates) {
            return $this->getOrderCounts($dates);
        });

        return view('pages.stats', compact('order_counts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function terms(Request $request)
    {
        return view('pages.terms');
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
}