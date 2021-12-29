<?php

namespace App\Listeners;

use Log;
use Cache;
use App\Events\OpenSeaWasCreated;
use App\Jobs\SendTelegramMessage;
use Droplister\XcpCore\App\Dispense;
use Droplister\XcpCore\App\Dispenser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OpenSeaListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\OpenSeaWasCreated  $event
     * @return void
     */
    public function handle(OpenSeaWasCreated $event)
    {
    	if($event->open_sea->total_volume_usd > 100000) {
    		$usd_value = number_format($event->open_sea->total_volume_usd / 100, 2);

	        $message = "*xOS* {$event->open_sea->quantity} [{$event->open_sea->asset}](https://xchain.io/asset/{$event->open_sea->asset})\n   @ {$event->open_sea->trade_price_payment_token} {$event->open_sea->payment_token}\n--\nTotal: {$usd_value} USD  [view]({$event->open_sea->permalink})";

	        SendTelegramMessage::dispatch($message, config('xcpdex.channel_id'), $event->open_sea->asset);
    	}
    }

    /**
     * To Decimal (divide)
     * 
     * @param  integer  $integer
     * @return string
     */
    private function toDecimal($integer, $decimals)
    {
        return bcdiv((int)(string)$integer, pow(10, $decimals), $decimals);
    }
}