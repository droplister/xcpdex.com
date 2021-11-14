<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Jobs\SendTelegramMessage;
use Droplister\XcpCore\App\Issuance;
use Droplister\XcpCore\App\Events\IssuanceWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IssuanceListener
{
    /**
     * Handle the event.
     *
     * @param  \Droplister\XcpCore\App\Events\OrderMatchWasCreated  $event
     * @return void
     */
    public function handle(OrderMatchWasCreated $event)
    {
        // Useful Switch
        if(config('xcp-core.indexing'))
        {
            if($event->issuance->assetModel->confirmed_at < Carbon::now()->subYears(6)) {
            	$year = $event->issuance->asset->confirmed_at->format('Y');
		        $message = "*New Issuance* [{$event->issuance->asset}](https://xchain.io/tx/{$event->issuance->tx_index}) ({$year})";

		        SendTelegramMessage::dispatch($message, config('xcpdex.bitcorn_channel_id'));
            }
        }
    }
}