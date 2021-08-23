<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'market_cap' => number_format($this->market_cap),
            'volume' => number_format($this->volume_normalized),
            'supply' => number_format($this->base_asset_supply),
            'base_asset' => $this->base_asset_display_name,
            'quote_asset' => $this->quote_asset_display_name,
            'price' => number_format($this->last_price, 8),
            'last_trade_date' => $this->last_trade_date,
            'open_orders_count' => number_format($this->open_orders_count),
            'orders_count' => number_format($this->orders_count),
            'order_matches_count' => number_format($this->order_matches_count),
        ];
    }
}
