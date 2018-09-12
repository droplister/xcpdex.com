<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('blocks.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $block)
    {
        return redirect(route('blocks.index'));
    }
}