<?php

namespace App\Http\Controllers;

use App\Feature;
use Droplister\XcpCore\App\Address;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $address
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $address)
    {
        $address = Address::whereAddress($address)->firstOrFail();

        // Features
        $features = Feature::highestBids()->with('market')->get();

        // Address First Active
        $first_trade = $address->orders()->orderBy('tx_index', 'asc')->first();

        // Address Last Active
        $last_trade = $address->orders()->orderBy('tx_index', 'desc')->first();

        // Address Total Trades
        $total_trades = $address->orders()->count();

        // Show View
        return view('addresses.show', compact('request', 'address', 'features', 'first_trade', 'last_trade', 'total_trades'));
    }
}