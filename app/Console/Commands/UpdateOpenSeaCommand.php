<?php

namespace App\Console\Commands;

use Log;
use Cache;
use Curl\Curl;
use App\OpenSea;
use OwenVoke\OpenSea\Client;
use Droplister\XcpCore\App\Send;
use Droplister\XcpCore\App\Asset;
use Illuminate\Console\Command;

class UpdateOpenSeaCommand extends Command
{
    /*
    |--------------------------------------------------------------------------
    | Update Open Sea Command
    |--------------------------------------------------------------------------
    |
    | The purpose of this command is to capture sales history.
    |
    */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:opensea {--o=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update OpenSea';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        // Latest Trades
        $response = $client->events()->all([
            'asset_contract_address' => '0x82c7a8f707110f5fbb16184a5933e9f78a34c6ab',
            'event_type' => 'successful',
            'limit' => 200,
            'offset' => $this->option('o'),
        ]);

        $this->recordEvents($response['asset_events']);
    }

    private function recordEvents($events)
    {
        // Parse for XCP
        foreach($events as $event)
        {
            $asset_name = null;

            // Skip Existing
            if (OpenSea::whereTxHash($event['transaction']['transaction_hash'])->exists()) continue;

            // Skip Bundles
            if ($event['asset'] === null) continue;

            // Test for Name
            $partial_test_1 = explode(' ', $event['asset']['name'])[0];
            $partial_test_2 = explode('.', str_replace('https://xchain.io/img/cards/', '', $event['asset']['image_original_url']))[0];

            // Do Name Match
            if($asset = Asset::where('asset_name', $partial_test_1)
                ->orWhere('asset_name', $partial_test_2)
                ->orWhere('asset_longname', $partial_test_1)
                ->orWhere('asset_longname', $partial_test_2)->first())
            {
                $asset_name = $asset->asset_name;
            }

            // Not Likely XCP
            if(! $asset_name) continue;

            // Emblem Data
            $curl = new Curl();
            $curl->setUserAgent('DIGIRARE.com');
            $curl->get($event['asset']['token_metadata']);

            if ($curl->error) {
                // No Certainty
            } else {
                $vault = json_decode($curl->response);

                // Very Certain
                if(count($vault->values) === 1 &&
                   $vault->values[0]->coin === 'XCP' &&
                   $vault->values[0]->name === $asset_name &&
                   $vault->addresses[0]->coin === 'BTC' &&
                   Send::whereAsset($asset_name)->whereDestination($vault->addresses[0]->address)->exists())
                {
                    $trade_price_usd = round($event['payment_token']['usd_price'] * $this->toDecimal($event['total_price'] / $vault->values[0]->balance, $event['payment_token']['decimals']) * 100, 0);

                    $trade_volume_usd = round($event['payment_token']['usd_price'] * $this->toDecimal($event['total_price'], $event['payment_token']['decimals']) * 100, 0);

                    $trade_price_payment_token = rtrim(rtrim($this->toDecimal($event['total_price'] / $vault->values[0]->balance, $event['payment_token']['decimals']), '0'), '.');

                    OpenSea::firstOrCreate([
                        'tx_hash' => $event['transaction']['transaction_hash'],
                    ], [
                        'permalink' => $event['asset']['permalink'],
                        'asset' => $asset_name,
                        'image' => $vault->values[0]->image,
                        'quantity' => $vault->values[0]->balance,
                        'trade_price_usd' => $trade_price_usd,
                        'total_volume_usd' => $trade_volume_usd,
                        'trade_price_payment_token' => $trade_price_payment_token,
                        'seller_name' => $event['seller']['user'] === null ? $event['seller']['address'] : $event['seller']['user']['username'],
                        'seller_address' => $event['seller']['address'],
                        'winner_name' => $event['winner_account']['user'] === null || $event['winner_account']['user']['username'] === null ? $event['winner_account']['address'] : $event['winner_account']['user']['username'],
                        'winner_address' => $event['winner_account']['address'],
                        'payment_token' => $event['payment_token']['symbol'],
                        'payment_token_decimals' => $event['payment_token']['decimals'],
                        'payment_token_eth_price' => $event['payment_token']['eth_price'],
                        'payment_token_usd_price' => $event['payment_token']['usd_price'],
                        'confirmed_at' => $event['transaction']['timestamp'],
                    ]);
                }
            }
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