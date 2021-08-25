<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Http\Request;

class OrderMatchesController extends Controller
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
        return view('matches.index', compact('request', 'featured'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        // Index View
        return redirect(route('matches.index'));
    }
}