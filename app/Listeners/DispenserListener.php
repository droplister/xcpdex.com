<?php

namespace App\Listeners;

use Log;
use Cache;
use App\Jobs\SendTelegramMessage;
use Droplister\XcpCore\App\Dispense;
use Droplister\XcpCore\App\Dispenser;
use Droplister\XcpCore\App\Events\DispenserWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispenserListener
{
    /**
     * Handle the event.
     *
     * @param  \Droplister\XcpCore\App\Events\DispenseWasCreated  $event
     * @return void
     */
    public function handle(DispenserWasCreated $event)
    {
    	if (in_array($event->dispenser->giveAssetModel->asset_name, ['XCP', 'BTC', 'PEPECASH', 'BITCORN'])) return;

    	if ($event->dispenser->giveAssetModel->divisible && $event->dispenser->giveAssetModel->issuance > 30000000000) return;

    	if (! $event->dispenser->giveAssetModel->divisible && $event->dispenser->giveAssetModel->issuance > 300) return;

        // Useful Switch
        if(config('xcp-core.indexing'))
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


        	$usd_value = str_replace(',', '', $event->dispenser->trading_price_normalized) * str_replace(',', '', $price_data['BTC']['price']);
    		$usd_value = number_format($usd_value);
            $give_amount = $event->dispenser->giveAssetModel->divisible ? $event->dispenser->escrow_quantity_normalized : str_replace('.00000000', '', $event->dispenser->escrow_quantity_normalized);
	        $message = "*Sell* {$give_amount} [{$event->dispenser->giveAssetModel->display_name}](https://xchain.io/asset/{$event->dispenser->giveAssetModel->display_name})\n   @ {$event->dispenser->trading_price_normalized} BTC\n--\nPrice: {$usd_value} USD  [disp.](https://xchain.io/tx/{$event->dispenser->tx_hash})";

	        SendTelegramMessage::dispatch($message, config('xcpdex.private_channel_id'), $event->dispenser->giveAssetModel->display_name);
        }
    }
}