<?php

namespace App\Http\Controllers;

use Curl\Curl;
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

        // BTC Balance
        $data = Cache::remember($cache_slug, 1, function () use ($address) {

            $curl = new Curl();
            $curl->setUserAgent('XCPDEX.com');
            $curl->get('https://blockstream.info/api/address/' . $address->address);

            if ($curl->error) {
                return [
                    'balance' => '0.00000000',
                    'txs' => 'API Failed',
                ];
            } else {
                $response = json_decode($curl->response);

                return $data = [
                    'balance' => fromSatoshi($response->chain_stats->funded_txo_sum - $response->chain_stats->spent_txo_sum),
                    'txs' => $response->chain_stats->tx_count . ' txs',
                ];
            }
        });

        // First Order
        $first_order = $address->orders()->orderBy('tx_index', 'asc')->first();

        // Last Order
        $last_order = $address->orders()->orderBy('tx_index', 'desc')->first();

        // Total Orders
        $total_orders = $address->orders()->count();

        // Show View
        return view('addresses.show', compact('request', 'address', 'data', 'first_order', 'last_order', 'total_orders'));
    }
}