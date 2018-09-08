<?php

namespace App\Http\Controllers\Api;

use Cache;
use App\Market;
use Carbon\Carbon;
use JsonRPC\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketChartController extends Controller
{
    /**
     * Counterblock API
     *
     * @var \JsonRPC\Client
     */
    protected $counterblock;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->counterblock = new Client(config('xcp-core.cb.api'));
        $this->counterblock->authentication(config('xcp-core.cb.user'), config('xcp-core.cb.password'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Market $market)
    {
        // Market Charts
        return Cache::remember('chart_' . $market->slug, 5,
            function () use ($market) {

            // Get History
            $data = $this->getMarketHistory($market);

            // New Array
            $history = [];
            $volumes = [];

            // Exception
            if(! $data) return $history;

            // Formatting
            foreach($data as $key => $row)
            {
                // Data OHLC
                $open = $row['open'];
                $high = $row['high'];
                $low = $row['low'];
                $close = $row['close'];
                $volume = $row['vol'];
                $midline = $row['midline'];

                // + History
                $history[] = [$row['interval_time'], $open, $high, $low, $close];

                // + Volumes
                $volumes[] = [$row['interval_time'], $volume];

                // Next Key
                $next= $key + 1;

                // Fill Data
                if(isset($data[$next]) && $data[$next]['interval_time'] - $row['interval_time'] > 3600000)
                {
                    // Timestamp
                    $timestamp = $row['interval_time'] + 3600000;

                    // Fill Data
                    while($timestamp <= $data[$next]['interval_time'])
                    {
                        // Flatline
                        $history[] = [$timestamp, $close, $close, $close, $close];
                        $volumes[] = [$timestamp, 0];

                        // Next Day
                        $timestamp = $timestamp + 3600000;
                    }
                }
            }

            // Book End
            $last = end($data);

            // One Day+
            if(Carbon::now()->timestamp * 1000 - $last['interval_time'] > 3600000)
            {
                // Data OHLC
                $open = $last['open'];
                $high = $last['high'];
                $low = $last['low'];
                $close = $last['close'];
                $volume = $last['vol'];
                $midline = $last['midline'];

                // Timestamp
                $timestamp = $last['interval_time'] + 3600000;

                // Book End
                while($timestamp <= Carbon::now()->timestamp * 1000)
                {
                    // Flatline
                    $history[] = [$timestamp, $close, $close, $close, $close];
                    $volumes[] = [$timestamp, 0];

                    // Next Day
                    $timestamp = $timestamp + 3600000;
                }
            }

            return [
                'history' => $history,
                'volumes' => $volumes,
            ];
        });
    }

    /**
     * Counterblock API
     * https://counterparty.io/docs/counterblock_api/#get_market_price_history
     *
     * @param  \App\Market  $market
     * @return mixed
     */
    private function getMarketHistory(Market $market)
    {
        return $this->counterblock->execute('get_market_price_history', [
            'asset1'   => $market->xcp_core_base_asset,
            'asset2'   => $market->xcp_core_quote_asset,
            'start_ts' => 1387065600, // First Block
            'as_dict'  => True,
        ]);
    }
}