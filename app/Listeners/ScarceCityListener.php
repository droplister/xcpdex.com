<?php

namespace App\Listeners;

use Log;
use Cache;
use App\Events\ScarceCityWasCreated;
use App\Jobs\SendTelegramMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScarceCityListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ScarceCityWasCreated  $event
     * @return void
     */
    public function handle(ScarceCityWasCreated $event)
    {
    	if($event->scarce_city->price_usd > 300000) {
    		$usd_value = number_format($event->scarce_city->price_usd / 100, 2);
	    	$btc_value = floatval(fromSatoshi($event->scarce_city->price_btc));

	    	$message = "*S.C* 1 [{$event->open_sea->asset}](https://xchain.io/asset/{$event->open_sea->asset})\n   @ {$btc_value} BTC\n--\nTotal: {$usd_value} USD  [view]({$event->scarce_city->permalink})";

		    SendTelegramMessage::dispatch($message, config('xcpdex.channel_id'), $event->scarce_city->asset);
		}
    }
}