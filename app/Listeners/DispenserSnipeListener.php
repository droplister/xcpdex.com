<?php

namespace App\Listeners;

use Log;
use Cache;
use App\Jobs\CreateSendTransaction;
use Droplister\XcpCore\App\Dispense;
use Droplister\XcpCore\App\Dispenser;
use Droplister\XcpCore\App\Events\DispenserWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispenserSnipeListener
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

        }
    }

    private function getWatchList()
    {
    	return [
    		'ASSET' => [
    			'max_satoshirate' =>
    			'max_quantity' => 
    		],
    	];
    }
}