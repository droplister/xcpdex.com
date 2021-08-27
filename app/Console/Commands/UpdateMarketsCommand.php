<?php

namespace App\Console\Commands;

use Cache;
use App\Market;
use Droplister\XcpCore\App\Block;
use App\Jobs\UpdateMarketVolumes;
use Illuminate\Console\Command;

class UpdateMarketsCommand extends Command
{
    /*
    |--------------------------------------------------------------------------
    | Update Markets Command
    |--------------------------------------------------------------------------
    |
    | The purpose of this command is to run each day and crunch some
    | stats that aren't worth crunching every single block.
    |
    */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:markets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Markets';

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
        // Get Block
        $block = Block::latest('block_index')->first();

        // Markets
        $markets_index = Cache::remember('market_index', 1440, function () {
            return Market::with('quoteAsset')
            ->selectRaw('COUNT(*) as count, xcp_core_quote_asset')
            ->where('xcp_core_quote_asset', '!=', 'XCP')
            ->where('xcp_core_quote_asset', '!=', 'BTC')
            ->where('volume', '>', 0)
            ->where('moderated', false)
            ->groupBy('xcp_core_quote_asset')
            ->orderBy('count', 'desc')
            ->orderBy('xcp_core_quote_asset')
            ->take(5)
            ->get();
        });

        // Get Markets
        $markets = Market::whereIn('xcp_core_quote_asset', ['XCP', 'BTC'])
            ->orWhereIn('xcp_core_quote_asset', $markets_index->pluck('xcp_core_quote_asset')->toArray())
            ->get();

        // Update Markets
        foreach($markets as $market)
        {
            // Update Job
            UpdateMarketVolumes::dispatch($market, $block);
        }
    }
}