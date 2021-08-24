<?php

namespace App\Providers;

use Cache;
use Droplister\XcpCore\App\Dispense;
use Droplister\XcpCore\App\Dispenser;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $price_data = Cache::remember('usd_prices', 1440, function () {
            $cmc = new \CoinMarketCap\Api(config('xcpdex.coinmarketcap'));

            $response1 = $cmc->cryptocurrency()->quotesLatest(['id' => 1, 'convert' => 'USD']);
            $response2 = $cmc->cryptocurrency()->quotesLatest(['id' => 132, 'convert' => 'USD']);
            $response3 = $cmc->cryptocurrency()->quotesLatest(['id' => 1405, 'convert' => 'USD']);

            $bitcorn_price = 0;
            $last_dispense = Dispense::whereAsset('BITCORN')->latest('confirmed_at')->first();

            if ($last_dispense) {
                $dispenser = Dispenser::whereTxHash($last_dispense->dispenser_tx_hash)->first();
                $bitcorn_price = fromSatoshi($dispenser->satoshirate / $dispenser->give_quantity) * $response1->data->{1}->quote->USD->price;
            }

            return [
                'BTC' => [
                    'price' => number_format($response1->data->{1}->quote->USD->price, 2),
                    'change' => number_format($response1->data->{1}->quote->USD->percent_change_1h, 0),
                ],
                'XCP' => [
                    'price' => number_format($response2->data->{132}->quote->USD->price, 2),
                    'change' => number_format($response2->data->{132}->quote->USD->percent_change_1h, 0),
                ],
                'PEPECASH' => [
                    'price' => number_format($response3->data->{1405}->quote->USD->price, 2),
                    'change' => number_format($response3->data->{1405}->quote->USD->percent_change_1h, 0),
                ],
                'BITCORN' => [
                    'price' => number_format($bitcorn_price, 4),
                ],
            ];
        });


        View::composer(['layouts.app', 'markets.index', 'markets.partials.table'], function ($view) use ($price_data) {
            $view->with('price_data', $price_data);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
