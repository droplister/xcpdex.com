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
                // Counterblock Logic
                $asset_pair = $this->getAssetPairFromAssets($market->xcp_core_base_asset, $market->xcp_core_quote_asset);

                // Reciprocal? (Y/N)
                $reciprocal = $asset_pair[0] === $market->xcp_core_quote_asset;

                // Data OHLC
                $open = number_format($reciprocal ? round(1 / $row['open'], 8) : $row['open'], 8);
                $high = number_format($reciprocal ? round(1 / $row['high'], 8) : $row['high'], 8);
                $low = number_format($reciprocal ? round(1 / $row['low'], 8) : $row['low'], 8);
                $close = number_format($reciprocal ? round(1 / $row['close'], 8) : $row['close'], 8);
                $volume = number_format($reciprocal ? round($row['vol'] / round(1 / $row['midline'], 8), 8) : $row['vol'], 8);

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
                    while($timestamp < $data[$next]['interval_time'])
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
                $close = number_format($reciprocal ? round(1 / $last['close'], 8) : $last['close'], 8);

                // Timestamp
                $timestamp = $last['interval_time'] + 3600000;

                // Book End
                while($timestamp < Carbon::now()->timestamp * 1000)
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

    /**
     * Counterblock Logic
     * https://github.com/CounterpartyXCP/counterblock/blob/92de24fe0881388b7ffa31ea68eab72f7f1a47d0/counterblock/lib/util.py#L70
     *
     * @param  string  $asset1
     * @param  string  $asset2
     * @return array
     */
    private function getAssetPairFromAssets($asset1, $asset2)
    {
        foreach(['BTC', 'XBTC', 'XCP'] as $quote_asset)
        {
            if($asset1 == $quote_asset || $asset2 == $quote_asset)
            {
                return $asset1 == $quote_asset ? [$asset2, $asset1] : [$asset1, $asset2];
            }
        }

        return $asset1 < $asset2 ? [$asset1, $asset2] : [$asset2, $asset1];
    }
}