<?php

namespace App\Http\Controllers\Api;

use Cache;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\OrderMatch;
use App\Http\Resources\OrderMatchResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderMatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Cached Matches
        $order_matches = Cache::remember('api_order_matches_' . $request->input('page', 1), 5, function () use ($request) {
            return OrderMatch::orderBy('tx1_index', 'desc')->paginate(30);
        });

        return [
            'order_matches' => OrderMatchResource::collection($order_matches),
            'last_page' => ceil($order_matches->total() / 30),
            'current_page' => (int) $request->input('page', 1),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chart(Request $request)
    {
        return Cache::remember('api_order_matches_chart', 1440, function() {
            $results = OrderMatch::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                ->groupBy('month', 'year')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            return CountResource::collection($results);
        });
    }
}