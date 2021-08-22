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

        // First Order
        $first_order = $address->orders()->orderBy('tx_index', 'asc')->first();

        // Last Order
        $last_order = $address->orders()->orderBy('tx_index', 'desc')->first();

        // Total Orders
        $total_orders = $address->orders()->count();

        // Show View
        return view('addresses.show', compact('request', 'address', 'first_order', 'last_order', 'total_orders'));
    }
}