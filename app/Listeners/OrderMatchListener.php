<?php

namespace App\Listeners;

use Log;
use Cache;
use App\Jobs\SendTelegramMessage;
use Droplister\XcpCore\App\Dispense;
use Droplister\XcpCore\App\Dispenser;
use Droplister\XcpCore\App\Events\OrderMatchWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMatchListener
{
    /**
     * Handle the event.
     *
     * @param  \Droplister\XcpCore\App\Events\OrderMatchWasCreated  $event
     * @return void
     */
    public function handle(OrderMatchWasCreated $event)
    {
    	    	Log::info('OL');

        // Useful Switch
        if(config('xcp-core.indexing'))
        {
        	    	Log::info('PD');

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


        	$usd_value = number_format((float) $event->order_match->trading_total_normalized * (float) $price_data[$event->order_match->trading_pair_quote_asset], 2);
        	Log::info($usd_value);
        	if($usd_value > 1) {
        		$usd_value = number_format($usd_value);
		        $message = "**{$event->order_match->trading_type}** {$event->order_match->trading_quantity_normalized} {$event->order_match->trading_pair_base_asset}\n@ {$event->order_match->trading_price_normalized} {$event->order_match->trading_pair_quote_asset}\n~ {$usd_value} USD [view tx](https://xchain.io/tx/{$event->order_match->tx1_index})";

		        SendTelegramMessage::dispatch($message);
        	}
        }
    }
}