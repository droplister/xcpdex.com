<?php

namespace App\Listeners;

use Log;
use Cache;
use Curl\Curl;
use App\OpenSea;
use Carbon\Carbon;
use App\Jobs\SnipeDispenser;
use Droplister\XcpCore\App\Dispense;
use Droplister\XcpCore\App\Dispenser;
use Droplister\XcpCore\App\OrderMatch;
use Droplister\XcpCore\App\Events\DispenserWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispenserSniperListener
{
    /**
     * Handle the event.
     *
     * @param  \Droplister\XcpCore\App\Events\DispenseWasCreated  $event
     * @return void
     */
    public function handle(DispenserWasCreated $event)
    {
        // Ignore These (currency)
    	if (in_array($event->dispenser->giveAssetModel->asset_name, ['XCP', 'BTC', 'PEPECASH', 'BITCORN'])) return;

        // High Supply (divisible)
        if ($event->dispenser->giveAssetModel->divisible && $event->dispenser->giveAssetModel->supply > 300000000000) return;

        // High Supply (not divis)
        if (! $event->dispenser->giveAssetModel->divisible && $event->dispenser->giveAssetModel->supply > 3000) return;

        // At Least 1 (divisible)
        if ($event->dispenser->giveAssetModel->divisible && $event->dispenser->give_quantity < 100000000) return;

        // At Least 1 (not divis)
        if (! $event->dispenser->giveAssetModel->divisible && $event->dispenser->give_quantity < 1) return;

        // Confirm Rare
        if($this->isRare($event)) {
            if($this->knownCheap($event) || $this->maybeCheap($event) || $event->dispenser->asset === 'PEPEANON') {
                if($event->dispenser->satoshirate < 10000000) {
                    SnipeDispenser::dispatchNow($event->dispenser);
                }
            }
        }
    }

    private function isRare($event) {
        $curl = new Curl();
        $curl->setUserAgent('XCPDEX.com');
        $curl->get('https://digirare.com/api/widget/' . $event->dispenser->giveAssetModel->asset_name);

        if ($curl->error) {
            return false;
        } else {
            $response = json_decode($curl->response);

            return $this->isDesirable($response);
        }

        return false;
    }

    private function isDesirable($response) {
        foreach ($response->data->collections as $collection) {
            if (in_array($collection->slug, [
               'age-of-chains',
               'age-of-rust',
               'force-of-will',
               'memorychain',
               'oasis-mining',
               'rare-pepe',
               'sarutobi-island',
               'skara',
               'spells-of-genesis',
            ])) {
                return true;
            }
        }

        return false;
    }

    private function knownCheap($event) {
        $usd_price = str_replace(',', '', $event->dispenser->trading_price_normalized) * $this->btcPrice();
        $os_traded = OpenSea::whereAsset($event->dispenser->giveAssetModel->asset_name)->count() > 1;
        $avg_price = OpenSea::whereAsset($event->dispenser->giveAssetModel->asset_name)->average('trade_price_usd') / 100;

        // At least 4x
        if ($os_traded && $usd_price / $avg_price < 0.25) {
            return true;
        }
    }

    private function btcPrice() {
        return Cache::remember('btc_price', 1440, function () {
            $cmc = new \CoinMarketCap\Api(config('xcpdex.coinmarketcap'));

            $response = $cmc->cryptocurrency()->quotesLatest(['id' => 1, 'convert' => 'USD']);

            return $response->data->{1}->quote->USD->price;
        });
    }

    private function maybeCheap($event) {
        $os_traded = OpenSea::whereAsset($event->dispenser->giveAssetModel->asset_name)->count() > 0;
        $dispensed = Dispenser::whereAsset($event->dispenser->giveAssetModel->asset_name)->count() > 0;
        $dextraded = OrderMatch::where('forward_asset', $event->dispenser->giveAssetModel->asset_name)->whereDate('confirmed_at', '>', Carbon::now()->subYears(2))->orWhere('backward_asset', $event->dispenser->giveAssetModel->asset_name)->whereDate('confirmed_at', '>', Carbon::now()->subYears(2))->count() > 0;

        if (!$os_traded && !$dispensed && !$dex_traded && $event->dispenser->satoshirate < 400000) {
            return true;
        }
    }
}
