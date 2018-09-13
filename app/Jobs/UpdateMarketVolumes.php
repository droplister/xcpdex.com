<?php

namespace App\Jobs;

use Cache;
use App\Market;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\OrderMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateMarketVolumes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Block
     *
     * @var \Droplister\XcpCore\App\Block
     */
    protected $block;

    /**
     * Market
     *
     * @var \App\Market
     */
    protected $market;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Market $market, Block $block)
    {
        $this->block = $block;
        $this->market = $market;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $buys_today = OrderMatch::where('backward_asset', '=', $this->market->xcp_core_base_asset)
            ->where('forward_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->where('confirmed_at', '>', $this->block->confirmed_at->subDays(1))
            ->sum('forward_quantity');

        $sells_today = OrderMatch::where('backward_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $this->market->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->where('confirmed_at', '>', $this->block->confirmed_at->subDays(1))
            ->sum('backward_quantity');

        // Volume
        $t_volume = $buys_today + $sells_today;

        // Update
        $this->market->update([
            'volume' => $t_volume,
        ]);

        // Forget
        Cache::forget('volume_normalized_' . $this->market->id);
    }
}