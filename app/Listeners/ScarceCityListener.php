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
    	if($event->scarce_city->price_usd > 100000) {
    		$usd_value = number_format($event->scarce_city->price_usd / 100, 2);
	    	$btc_value = $this->trimTrailingZeroes(fromSatoshi($event->scarce_city->price_btc));

	    	$message = "*S.C* 1 [{$event->scarce_city->asset}](https://xchain.io/asset/{$event->scarce_city->asset})\n   @ {$btc_value} BTC\n--\nTotal: {$usd_value} USD  [view]({$event->scarce_city->permalink})";

		    SendTelegramMessage::dispatch($message, config('xcpdex.channel_id'), $event->scarce_city->asset);
		}
    }

    private function trimTrailingZeroes($nbr) {
        if(strpos($nbr,'.')!==false) $nbr = rtrim($nbr,'0');

        return rtrim($nbr,'.') ?: '0';
    }
}