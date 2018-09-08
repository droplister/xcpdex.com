<?php

namespace App\Jobs;

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

        $buys_yesterday = OrderMatch::where('backward_asset', '=', $this->market->xcp_core_base_asset)
            ->where('forward_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->where('confirmed_at', '>', $this->block->confirmed_at->subDays(2))
            ->where('confirmed_at', '<', $this->block->confirmed_at->subDays(1))
            ->sum('forward_quantity');

        $sells_yesterday = OrderMatch::where('backward_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $this->market->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->where('confirmed_at', '>', $this->block->confirmed_at->subDays(2))
            ->where('confirmed_at', '<', $this->block->confirmed_at->subDays(1))
            ->sum('backward_quantity');

        $t_volume = $buys_today + $sells_today;
        $y_volume = $buys_yesterday + $sells_yesterday;
        $change = $y_volume === 0 ? ($d_volume / $y_volume - 1) * 100 : 100;

        $this->market->update([
            'volume' => $t_volume,
            'change' => $change,
        ]);
    }
}