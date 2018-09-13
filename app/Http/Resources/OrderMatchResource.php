<?php

namespace App\Http\Resources;

use Droplister\XcpCore\App\Asset;
use Illuminate\Http\Resources\Json\Resource;

class OrderMatchResource extends Resource
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
            'tx_hash' => $this->tx1_hash,
            'type' => $this->trading_type,
            'base_asset' => $this->trading_pair_base_asset,
            'quote_asset' => $this->trading_pair_quote_asset,
            'date' => $this->confirmed_at->toDateTimeString(),
            'market' => $this->trading_pair_normalized,
            'market_slug' => str_replace('/', '_', $this->trading_pair_normalized),
            'buyer' => $this->trading_buyer_normalized,
            'seller' => $this->trading_seller_normalized,
            'price' => $this->trading_price_normalized,
            'quantity' => $this->trading_quantity_normalized,
            'total' => $this->trading_total_normalized,
        ];
    }
}