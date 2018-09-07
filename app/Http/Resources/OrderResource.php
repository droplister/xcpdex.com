<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // Trading Pair
        $base_asset = explode('/', $this->trading_pair_normalized)[0];
        $quote_asset = explode('/', $this->trading_pair_normalized)[1];

        // Base Quantity
        $quantity = ($base_asset === $this->get_asset) ? $this->get_remaining_normalized : $this->give_remaining_normalized;

        return [
            'source' => $this->source,
            'quantity' => $quantity,
            'price' => $this->trading_price_normalized,
            'total' => ($quantity * $this->trading_price_normalized),
        ];
    }
}