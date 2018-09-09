<?php

namespace App\Listeners;

use App\Market;
use App\Jobs\UpdateMarketVolumes;
use Droplister\XcpCore\App\Events\BlockWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlockListener
{
    /**
     * Handle the event.
     *
     * @param  \Droplister\XcpCore\App\Events\BlockWasCreated  $event
     * @return void
     */
    public function handle(BlockWasCreated $event)
    {
        // Useful Switch
        if(config('xcp-core.indexing')) return false;

        // Get Markets
        $markets = Market::get();

        // Update Vol.
        foreach($markets as $market)
        {
            UpdateMarketVolumes::dispatch($market, $event->block);
        }
    }
}