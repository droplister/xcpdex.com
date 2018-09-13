<?php

namespace App\Http\Controllers\Api;

use Cache;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\Order;
use App\Http\Resources\CountResource;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Cache Slug
        $cache_slug = 'api_orders_index_' . str_slug(serialize($request->all()));

        // Get Orders
        $orders = Cache::remember($cache_slug, 10, function () use ($request) {
            // Block Index
            $block = Block::latest('block_index')->first();

            // Open Orders (Oldest)
            if($request->input('status') === 'ending-soon')
            {
                return Order::where('expire_index', '>', $block->block_index)
                    ->where('give_remaining', '>', 0)
                    ->where('get_remaining', '>', 0)
                    ->where('status', '=', 'open')
                    ->orderBy('expire_index', 'asc')
                    ->paginate(30);
            }

            // Open Orders (Newest)
            return Order::where('expire_index', '>', $block->block_index)
                ->where('give_remaining', '>', 0)
                ->where('get_remaining', '>', 0)
                ->where('status', '=', 'open')
                ->orderBy('tx_index', 'desc')
                ->paginate(30);
        });

        return [
            'orders' => OrderResource::collection($orders),
            'last_page' => ceil($orders->total() / 30),
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
        return Cache::remember('api_orders_chart', 1440, function() {
            $results = Order::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                ->groupBy('month', 'year')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            return CountResource::collection($results);
        });
    }
}