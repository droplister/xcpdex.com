<?php

namespace App\Providers;

use Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        View::composer('app', function ($view) {
	        $data = Cache::remember('nav_prices', 30, function () {
	            $cmc = new CoinMarketCap\Api(config('xcpdex.coinmarketcap'));

	            $response1 = $cmc->tools()->priceConversion(['amount' => 1, 'symbol' => 'BTC']);
	            $response2 = $cmc->tools()->priceConversion(['amount' => 1, 'symbol' => 'XCP']);

	            return [
	            	'btc_price' => $response1->data->quote->USD->price,
	            	'xcp_price' => $response2->data->quote->USD->price,
	            ];
	        });

            $view->with('btc_price', $data['btc_price']);
            $view->with('xcp_price', $data['xcp_price']);
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
}
