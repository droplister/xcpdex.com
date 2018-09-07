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
        $base = explode('/', $event->order->trading_pair_normalized)[0];
        $base_asset = Asset::where('asset_name', '=', $base)->orWhere('asset_longname', '=', $base)->first();

        // Quote Asset
        $quote = explode('/', $event->order->trading_pair_normalized)[1];
        $quote_asset = Asset::where('asset_name', '=', $quote)->orWhere('asset_longname', '=', $quote)->first();

        // Trading Pair
        Market::firstOrCreate([
            'xcp_core_base_asset' => $base_asset->asset_name,
            'xcp_core_quote_asset' => $quote_asset->asset_name,
            'name' => "{$base_asset->display_name}/{$quote_asset->display_name}",
        ]);
    }
}