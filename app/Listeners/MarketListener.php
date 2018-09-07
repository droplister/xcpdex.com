<?php

namespace App\Listeners;

use App\Market;
use Droplister\XcpCore\App\Events\OrderWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarketListener
{
    /**
     * Handle the event.
     *
     * @param  \Droplister\XcpCore\App\Events\OrderWasCreated  $event
     * @return void
     */
    public function handle(OrderWasCreated $event)
    {
        Market::firstOrCreate([
            'xcp_core_base_asset' => explode('/', $event->order->trading_pair_normalized)[0],
            'xcp_core_quote_asset' => explode('/', $event->order->trading_pair_normalized)[1],
            'name' => $event->order->trading_pair_normalized,
        ]);
    }
}