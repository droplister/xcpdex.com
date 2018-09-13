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
        // Block Index
        $block_index = Cache::get('block_index') ? Cache::get('block_index') : Block::latest('block_index')->first()->block_index;

        // Cache Slug
        $cache_slug = 'api_orders_index_' . $block_index . '_' . str_slug(serialize($request->all()));

        // Get Orders
        return Cache::remember($cache_slug, 60, function () use ($block_index, $request) {
            // Check Status
            if($request->input('status') === 'ending-soon')
            {
                // Open Orders (Oldest)
                $orders = Order::where('expire_index', '>', $block_index)
                    ->where('give_remaining', '>', 0)
                    ->where('get_remaining', '>', 0)
                    ->where('status', '=', 'open')
                    ->orderBy('expire_index', 'asc')
                    ->paginate(30);
            }
            else
            {
                // Open Orders (Newest)
                $orders = Order::where('expire_index', '>', $block_index)
                    ->where('give_remaining', '>', 0)
                    ->where('get_remaining', '>', 0)
                    ->where('status', '=', 'open')
                    ->orderBy('tx_index', 'desc')
                    ->paginate(30);
            }

            return [
                'orders' => OrderResource::collection($orders),
                'last_page' => ceil($orders->total() / 30),
                'current_page' => (int) $request->input('page', 1),
            ];
        });
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