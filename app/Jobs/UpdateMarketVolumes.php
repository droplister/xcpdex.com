<?php

namespace App\Jobs;

use Cache;
use App\Market;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\Order;
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
        // Dates
        $start_date = $this->block->confirmed_at->subDays(30)->toDateTimeString();
        $end_date = $this->block->confirmed_at->toDateTimeString();

        // Buys
        $buys_today = OrderMatch::where('backward_asset', '=', $this->market->xcp_core_base_asset)
            ->where('forward_asset', '=', $this->market->xcp_core_quote_asset)
            ->whereBetween('confirmed_at', [$start_date, $end_date])
            ->where('status', '=', 'completed')
            ->sum('forward_quantity');

        // Sells
        $sells_today = OrderMatch::where('backward_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $this->market->xcp_core_base_asset)
            ->whereBetween('confirmed_at', [$start_date, $end_date])
            ->where('status', '=', 'completed')
            ->sum('backward_quantity');

        // Volume
        $m_volume = $buys_today + $sells_today;

        // Orders
        $t_orders_count = Order::where('get_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('give_asset', '=', $this->market->xcp_core_base_asset)
            ->orWhere('get_asset', '=', $this->market->xcp_core_base_asset)
            ->where('give_asset', '=', $this->market->xcp_core_quote_asset)
            ->count();

        $get_orders_count = Order::where('get_asset', '=', $this->market->xcp_core_base_asset)
            ->where('give_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('status', '=', 'open')
            ->count();

        $give_orders_count = Order::where('get_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('give_asset', '=', $this->market->xcp_core_base_asset)
            ->where('status', '=', 'open')
            ->count();

        // Order Matches
        $t_order_matches_count = OrderMatch::where('backward_asset', '=', $this->market->xcp_core_quote_asset)
            ->where('forward_asset', '=', $this->market->xcp_core_base_asset)
            ->orWhere('backward_asset', '=', $this->market->xcp_core_base_asset)
            ->where('forward_asset', '=', $this->market->xcp_core_quote_asset)
            ->count();

        // Last Match
        $last_match = $this->market->lastMatch();

        // Update
        $this->market->update([
            'volume' => $m_volume,
            'orders_count' => $t_orders_count,
            'get_orders_count' => $get_orders_count,
            'give_orders_count' => $give_orders_count,
            'open_orders_count' => $get_orders_count + $give_orders_count,
            'order_matches_count' => $t_order_matches_count,
            'base_asset_supply' => $this->market->baseAsset->supply_normalized,
            'last_price' => $last_match ? $last_match->trading_price_normalized : number_format(0, 8),
            'last_trade_date' => $last_match ? $last_match->confirmed_at->toDateTimeString() : '----',
            'market_cap' => $last_match ? round($this->market->baseAsset->supply_normalized * $last_match->trading_price_normalized) : 0,
        ]);

        // Forget
        Cache::forget('volume_normalized_' . $this->market->id);
    }
}