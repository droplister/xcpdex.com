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
        $base_asset = Asset::where('asset_name', '=', $event->order->trading_pair_base_asset)
            ->orWhere('asset_longname', '=', $event->order->trading_pair_base_asset)
            ->first();

        // Quote Asset
        $quote_asset = Asset::where('asset_name', '=', $event->order->trading_pair_quote_asset)
            ->orWhere('asset_longname', '=', $event->order->trading_pair_quote_asset)
            ->first();

        // Trading Pair
        Market::firstOrCreate([
            'xcp_core_base_asset' => $base_asset->asset_name,
            'xcp_core_quote_asset' => $quote_asset->asset_name,
            'name' => $event->order->trading_pair_normalized,
        ]);
    }
}