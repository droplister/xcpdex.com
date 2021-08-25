<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Featured
        $featured = Feature::highestBids()->with('market')->first();

        // Index View
        return view('orders.index', compact('request', 'featured'));
    }
}