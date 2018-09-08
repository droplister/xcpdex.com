<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MempoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('mempool.index');
    }
}