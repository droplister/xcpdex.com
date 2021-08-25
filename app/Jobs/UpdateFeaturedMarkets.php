<?php

namespace App\Jobs;

use App\Market;
use App\Feature;
use Droplister\XcpCore\App\Send;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateFeaturedMarkets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Block Index
     *
     * @var integer
     */
    protected $block_index;

    /**
     * Create a new job instance.
     *
     * @param  \App\Cause  $cause
     * @return void
     */
    public function __construct($block_index)
    {
        $this->block_index = $block_index;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // API Data
        $sends = $this->getSends();

        foreach($sends as $send)
        {
            // Featured Market
            $name = str_replace('"', '', hex2bin($send->memo));

            // Flexible Inputs
            $market = $this->getMarket($name);

            // Simplest Check
            if($market !== null && ! $this->banned($send->source))
            {
                Feature::firstOrCreate([
                    'xcp_core_tx_index' => $send->tx_index,
                ],[
                    'market_id' => $market->id,
                    'address' => $send->source,
                    'bid' => $send->quantity,
                ]);
            }
        }    
    }

    /**
     * Counterparty API
     * https://counterparty.io/docs/api/#get_table
     *
     * @return mixed
     */
    private function getSends()
    {
        return Send::where('asset', '=', 'XCP')
            ->where('destination', '=', config('xcpdex.feature_address'))
            ->where('status', '=', 'valid')
            ->where('block_index', '<=', $this->block_index - 2)
            ->get();
    }

    /**
     * Get Market
     *
     * @param  string  $name
     * @return \App\Market
     */
    private function getMarket($name)
    {
        // Simplest
        $market = $this->getMarketByName($name);

        // Trading Pair
        $name = explode('/', $name);

        // Flexible
        if(! $market && count($name) === 2)
        {
            $name = "{$name[1]}/{$name[0]}";
            $market = $this->getMarketByName($name);
        }

        return $market;
    }

    /**
     * Get Market by Name
     *
     * @param  string  $name
     * @return \App\Market
     */
    private function getMarketByName($name)
    {
        return Market::where('name', '=', $name)
            ->orWhere('slug', '=', $name)
            ->first();
    }

    /**
     * Ban Bidder Address
     *
     * @param  string  $address
     * @return boolean
     */
    private function banned($address)
    {
        return in_array($address, [
            '1LegitZpuAerkiWnaWVpTrazCULcUuJoUW',
        ]);
    }
}