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
        View::composer('layouts.app', function ($view) {
            $price_data = Cache::remember('nav_prices', 30, function () {
                $cmc = new \CoinMarketCap\Api(config('xcpdex.coinmarketcap'));

                    $response1 = $cmc->cryptocurrency()->quotesLatest(['id' => 1, 'convert' => 'USD']);
                    $response2 = $cmc->cryptocurrency()->quotesLatest(['id' => 132, 'convert' => 'USD']);
                    $response3 = $cmc->cryptocurrency()->quotesLatest(['id' => 1405, 'convert' => 'USD']);

                return [
                    'btc' => [
                            'price' => number_format($response1->data->{1}->quote->USD->price, 2),
                            'change' => number_format($response1->data->{1}->quote->USD->percent_change_24h, 0),
                        ],
                    'xcp' => [
                            'price' => number_format($response2->data->{132}->quote->USD->price, 2),
                            'change' => number_format($response2->data->{132}->quote->USD->percent_change_24h, 0),
                        ],
                    'pepecash' => [
                            'price' => number_format($response3->data->{1405}->quote->USD->price, 2),
                            'change' => number_format($response3->data->{1405}->quote->USD->percent_change_24h, 0),
                        ],
                ];
            });

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
