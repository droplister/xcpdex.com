<?php

namespace App\Http\Resources;

use Cache;
use Droplister\XcpCore\App\Block;
use Droplister\XcpCore\App\Asset;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request, $block_index)
    {
        // Block Index
        $block_index = Cache::get('block_index') ? Cache::get('block_index') : Block::latest('block_index')->first()->block_index;

        return [
            'tx_hash' => $this->tx_hash,
            'type' => $this->trading_type,
            'base_asset' => $this->trading_pair_base_asset,
            'quote_asset' => $this->trading_pair_quote_asset,
            'date' => $this->confirmed_at->toDateTimeString(),
            'market' => $this->trading_pair_normalized,
            'market_slug' => str_replace('/', '_', $this->trading_pair_normalized),
            'source' => $this->source,
            'status' => $this->status,
            'price' => $this->trading_price_normalized,
            'quantity' => $this->trading_quantity_normalized,
            'total' => $this->trading_total_normalized,
            'blocks_left' => $this->expire_index - $block_index,
        ];
    }
}