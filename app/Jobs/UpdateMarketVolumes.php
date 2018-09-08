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
        $buys_today = OrderMatch::where('backward_asset', '=', $market->xcp_core_base_asset)
            ->where('forward_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->where('confirmed_at', '>', $this->block->confirmed_at->subDays(1))
            ->sum('forward_quantity');

        $sells_today = OrderMatch::where('backward_asset', '=', $market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $market->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->where('confirmed_at', '>', $this->block->confirmed_at->subDays(1))
            ->sum('backward_quantity');

        $buys_yesterday = OrderMatch::where('backward_asset', '=', $market->xcp_core_base_asset)
            ->where('forward_asset', '=', $market->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->where('confirmed_at', '>', $this->block->confirmed_at->subDays(2))
            ->where('confirmed_at', '<', $this->block->confirmed_at->subDays(1))
            ->sum('forward_quantity');

        $sells_yesterday = OrderMatch::where('backward_asset', '=', $market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $market->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->where('confirmed_at', '>', $this->block->confirmed_at->subDays(2))
            ->where('confirmed_at', '<', $this->block->confirmed_at->subDays(1))
            ->sum('backward_quantity');

        $24h_volume = $buys_today + $sells_today;
        $last_24h_volume = $buys_yesterday + $sells_yesterday;
        $24h_change = $last_24h_volume === 0 ? ($24h_volume / $last_24h_volume - 1) * 100 : 100;

        $this->market->update([
            'volume' => $24h_volume,
            'change' => $24h_change,
        ]);
    }
}