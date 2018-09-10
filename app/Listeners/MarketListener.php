<?php

namespace App\Listeners;

use App\Market;
use Droplister\XcpCore\App\Asset;
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
        // Base Asset
        $base_asset = Asset::where('asset_name', '=', explode('/', $event->order->trading_pair_normalized)[0])
            ->orWhere('asset_longname', '=', explode('/', $event->order->trading_pair_normalized)[0])
            ->first();

        // Quote Asset
        $quote_asset = Asset::where('asset_name', '=', explode('/', $event->order->trading_pair_normalized)[1])
            ->orWhere('asset_longname', '=', explode('/', $event->order->trading_pair_normalized)[1])
            ->first();

        // Trading Pair
        Market::firstOrCreate([
            'xcp_core_base_asset' => $base_asset->asset_name,
            'xcp_core_quote_asset' => $quote_asset->asset_name,
            'name' => "{$base_asset->display_name}/{$quote_asset->display_name}",
        ]);
    }
}