<?php

namespace App\Http\Controllers;

use App\Market;
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
        return redirect(route('markets.index'));
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
        // Get Market
        $market = Market::where('xcp_core_base_asset', '=', $asset)
            ->orWhere('name', 'like', $asset . '%')
            ->orderBy('volume', 'desc')
            ->first();

        return $market ? redirect(route('markets.show', ['market' => $market->slug])) : redirect(route('markets.index'));
    }
}