<?php

namespace App\Http\Controllers;

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

        // Address First Active
        $first_trade = $address->orders()->latest('tx_index')->first();

        // Address Last Active
        $last_trade = $address->orders()->oldest('tx_index')->first();

        // Address Total Trades
        $total_trades = $address->orders()->count();

        // Show View
        return view('addresses.show', compact('request', 'address', 'first_trade', 'last_trade', 'total_trades'));
    }
}