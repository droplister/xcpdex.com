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
        // Features
        $features = Feature::highestBids()->with('market')->get();

        // Index View
        return view('matches.index', compact('features'));
    }
}