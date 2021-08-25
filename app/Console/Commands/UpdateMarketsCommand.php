<?php

namespace App\Console\Commands;

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

        // Get Markets
        $markets = Market::get();

        // Update Markets
        foreach($markets as $market)
        {
            // Update Job
            UpdateMarketVolumes::dispatch($market, $block);
        }
    }
}