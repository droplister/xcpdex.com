<?php

namespace App\Http\Controllers;

use JsonRPC\Client;
use App\Http\Requests\CreateOrderRequest;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    // New Up

    public function __construct()
    {
        /**
         * API Connections
         *
         * Setting: .env
         * Default: coindaddy.io
         */
        $this->counterblock = new Client(config('xcp-core.cb.api'));
        $this->counterblock->authentication(config('xcp-core.cb.user'), config('xcp-core.cb.password'));

        $this->counterparty = new Client(config('xcp-core.cp.api'));
        $this->counterparty->authentication(config('xcp-core.cp.user'), config('xcp-core.cp.password'));
    }

    // New Orders

    public function getOrders()
    {
        $orders = $this->counterparty->execute('get_orders', [
            'order_by'  => 'block_index',
            'order_dir' => 'desc',
            'limit' => 100,
        ]);

        return view('orders', ['orders' => $orders]);
    }

    // Order Form

    public function getOrder(Request $request)
    {
        return view('order.create', ['request' => $request]);
    }

    // Create Order

    public function postOrder(CreateOrderRequest $request)
    {
        /**
         * Unpack the request for clarity
         * to readers of the source code.
         */
        $get_asset = $request->get_asset;
        $get_quantity = (int) toSatoshi($request->get_quantity);

        $give_asset = $request->give_asset;
        $give_quantity = (int) toSatoshi($request->give_quantity);

        $source = $request->source;
        $expiration = (int) $request->expiration;

        /**
         * get_pubkey_for_address returns none
         * for addresses that aren't used yet.
         *
         * So, I use it to do basic validation.
         */
        if( $pubkey = $this->counterblock->execute('get_pubkey_for_address', ['address' => $source] ) )
        {
            /**
             * A source address should have enough
             * BTC for fees around 10,000 satoshis.
             */
            if ( $this->guardAgainstInsufficientBitcoinBalance($source) )
            {
                return redirect()->route('order')->withInput()->with('warning', 'Insufficient BTC at this address. At least 0.0001 BTC is required for fees.');
            }

            /**
             * A source address should have enough
             * give_asset for filling their order.
             */
            if ( $this->guardAgainstInsufficientAssetBalance($source, $give_asset, $give_quantity) )
            {
                $give_quantity = unSatoshi($give_quantity);
                return redirect()->route('order')->withInput()->with('warning', "Insufficient {$give_asset} at this address. At least {$give_quantity} is required.");
            }

            /**
             * The source address has the funds.
             * This creates an unsigned raw tx.
             */
            $orderHex = $this->counterparty->execute('create_order', [
                'source' => $source,
                'pubkey' => $pubkey,
                'give_asset'    => $give_asset,       
                'give_quantity' => $give_quantity,
                'get_asset'     => $get_asset,
                'get_quantity'  => $get_quantity,
                'expiration'    => $expiration,
                'allow_unconfirmed_inputs' => true,
                'fee_required' => 0,
            ]);

            /**
             * Send user to success page so they
             * can receive their raw tx hex code.
             */
            return redirect()->route('order::result')->withInput()->with('success', $orderHex);
        }

        /**
        * Unknown Address / Result
        */
        return redirect()->route('order')->withInput()->with('warning', "Your address: {$source} does not appear to be actively used.");
    }

    // Order Result

    public function getResult()
    {
        /**
         * Not stored, don't reload
         */
        return view('order.raw-tx');
    }

    // GUARDS

    protected function guardAgainstInsufficientBitcoinBalance($address)
    {
        /**
         * Uses Blockchain.info
         * (Hardcoded for now.)
         */
        $curl = new \anlutro\cURL\cURL;
        $response = $curl->get("https://blockchain.info/q/addressbalance/{$address}?confirmations=0");

        /**
         * Returns false if the
         * funds are sufficient
         */
        if ( $response->body > 0.0001 ) return false;

        /**
         * We have a problem.
         */
        return true;
    }

    protected function guardAgainstInsufficientAssetBalance($address, $asset, $quantity)
    {
        $results = $this->counterparty->execute('get_balances', [
            'filters' => [
                'field' => 'address',
                'op'    => '==',
                'value' => $address,
        ]]);

        /**
         * Look at all their balances.
         *
         * Not sure if there is a more
         * direct way to check these??
         */
        foreach ( $results as $result )
        {
            /**
             * Match by Name
             */
            if ( $asset === $result['asset'] )
            {
                /**
                 * Returns false if their
                 * asset balance is okay.
                 */
                if ( $quantity <= $result['quantity'] )
                {
                    return false;
                }
            }
        }

        /**
         * We have a problem.
         */
        return true;
    }

}
