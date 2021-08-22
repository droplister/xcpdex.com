<?php

namespace App\Providers;

use Cache;
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
        $price_data = Cache::remember('nav_pricesfd22s', 30, function () {
            $cmc = new \CoinMarketCap\Api(config('xcpdex.coinmarketcap'));

                $response1 = $cmc->cryptocurrency()->quotesLatest(['id' => 1, 'convert' => 'USD']);
                $response2 = $cmc->cryptocurrency()->quotesLatest(['id' => 132, 'convert' => 'USD']);
                $response3 = $cmc->cryptocurrency()->quotesLatest(['id' => 1405, 'convert' => 'USD']);

            return [
                'BTC' => [
                    'price' => number_format($response1->data->{1}->quote->USD->price, 2),
                    'change' => number_format($response1->data->{1}->quote->USD->percent_change_24h, 0),
                ],
                'XCP' => [
                    'price' => number_format($response2->data->{132}->quote->USD->price, 2),
                    'change' => number_format($response2->data->{132}->quote->USD->percent_change_24h, 0),
                ],
                'PEPECASH' => [
                    'price' => number_format($response3->data->{1405}->quote->USD->price, 2),
                    'change' => number_format($response3->data->{1405}->quote->USD->percent_change_24h, 0),
                ],
            ];
        });


        View::composer(['layouts.app', 'markets.partials.table'], function ($view) use ($price_data) {
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
