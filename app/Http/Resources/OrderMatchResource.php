<?php

namespace App\Http\Resources;

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
        // Trading Pair
        $base_asset = explode('/', $this->trading_pair_normalized)[0];
        $quote_asset = explode('/', $this->trading_pair_normalized)[1];

        // Base Quantity
        $quantity = ($base_asset === $this->backward_asset) ? $this->backward_quantity_normalized : $this->forward_quantity_normalized;

        return [
            'source' => $this->source,
            'quantity' => $quantity,
            'price' => $this->trading_price_normalized,
            'total' => ($quantity * $this->trading_price_normalized),
        ];
    }
}