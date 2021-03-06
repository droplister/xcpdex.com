<?php

namespace App\Listeners;

use App\Market;
use App\Jobs\UpdateFeaturedMarkets;
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
        if(config('xcp-core.indexing'))
        {
            // Get Orders
            $orders = $event->block->orders->merge($event->block->expirations);

            // Update Markets
            foreach($orders as $order)
            {
                // Get Market
                $market = Market::where('name', '=', $order->trading_pair_normalized)->first();

                // Update Job
                UpdateMarketVolumes::dispatch($market, $event->block);
            }

            // Save Stats
            UpdateFeaturedMarkets::dispatch($event->block->block_index);
        }
    }
}