<?php

namespace App\Http\Controllers\Api;

use App\Market;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\Order;
use App\Http\Resources\AssetResource;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Market $market)
    {
        // Current Block Index
        $block = Block::latest('block_index')->first();

        // Market's Buy Orders
        $buy_orders = Order::where('get_asset', '=', $market->xcp_core_base_asset)
            ->where('give_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'open')
            ->where('expire_index', '>', $block->block_index)
            ->get()
            ->sortByDesc('trading_price_normalized')
            ->sortBy('tx_index');

        // Market's Sell Orders
        $sell_orders = Order::where('give_asset', '=', $market->xcp_core_base_asset)
            ->where('get_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'open')
            ->where('expire_index', '>', $block->block_index)
            ->get()
            ->sortBy('trading_price_normalized')
            ->sortBy('tx_index');

        return [
            'base_asset' => new AssetResource($market->baseAsset),
            'quote_asset' => new AssetResource($market->quoteAsset),
            'buy_orders' => OrderResource::collection($buy_orders),
            'sell_orders' => OrderResource::collection($sell_orders),
        ];
    }
}