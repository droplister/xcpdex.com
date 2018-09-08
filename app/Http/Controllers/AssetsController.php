<?php

namespace App\Http\Controllers;

use Droplister\XcpCore\App\Asset;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('assets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $asset)
    {
        $asset = Asset::where('asset_name')->orWhere('asset_longname')->firstOrFail();

        return view('assets.show', compact('asset'));
    }
}