<?php

namespace App\Http\Controllers;

use Cache;
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

        // Index View
        return view('home.index', compact('price_data'));
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