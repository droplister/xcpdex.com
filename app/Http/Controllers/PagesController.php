<?php

namespace App\Http\Controllers;

use App\Feature;
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
        // Features
        $features = Feature::highestBids()->with('market')->get();

        return view('pages.disclaimer', compact('features'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function privacy(Request $request)
    {
        // Features
        $features = Feature::highestBids()->with('market')->get();

        return view('pages.privacy', compact('features'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function terms(Request $request)
    {
        // Features
        $features = Feature::highestBids()->with('market')->get();

        return view('pages.terms', compact('features');
    }
}