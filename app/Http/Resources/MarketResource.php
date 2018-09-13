<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MarketResource extends Resource
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
            'market_cap' => number_format($this->baseAsset->supply_normalized * $this->lastMatch()->trading_price_normalized),
            'volume' => $this->volume_normalized,
            'supply' => $this->baseAsset->supply_normalized,
            'base_asset' => $this->baseAsset->display_name,
            'quote_asset' => $this->quoteAsset->display_name,
            'price' => $this->last_price,
        ];
    }
}
