<?php

namespace App\Http\Controllers\Api;

use Cache;
use Droplister\XcpCore\App\Order;
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
        $orders = Cache::remember('api_orders_' . $request->input('page', 1), 5, function () {
            return Order::orderBy('tx_index', 'desc')->paginate(30);
        });

        return [
            'orders' => OrderResource::collection($orders),
            'last_page' => ceil($orders->total() / 30),
            'current_page' => (int) $request->input('page', 1),
        ];
    }
}