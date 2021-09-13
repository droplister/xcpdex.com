<?php

namespace App\Console\Commands;

use Log;
use Cache;
use Curl\Curl;
use App\ScarceCity;
use Droplister\XcpCore\App\Asset;
use Illuminate\Console\Command;

class UpdateScarceCityCommand extends Command
{
    /*
    |--------------------------------------------------------------------------
    | Update Scarce City Command
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
    protected $signature = 'update:scarcecity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Scarce City';

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
        $curl = new Curl();
        $curl->setUserAgent('DIGIRARE.com');
        $curl->get(config('xcpdex.scarce_city_api'));

        if ($curl->error) {
            // Whoops
        } else {
            $sales = json_decode($curl->response);

            foreach($sales as $sale) {
                // Skip Existing
                if (ScareCity::whereAsset($sale['asset'])->whereTimestamp($sale['timestamp'])->exists()) continue;

                // Validate Asset
                if (! Asset::whereAssetName($sale['asset'])->exists()) continue;

            	$this->recordSale($sale);
            }
        }
    }

    private function recordSale($sale)
    {
        // Save This Sale
        ScarceCity::firstOrCreate([
	        'asset' => $sale['asset'],
	        'timestamp' => $sale['timestamp'],
        ], [
	        'permalink' => $sale['listing_url'],
	        'price_btc' => toSatoshi($sale['price_btc']),
	        'price_usd' => $sale['price_usd'] * 100,
        ]);
    }
}