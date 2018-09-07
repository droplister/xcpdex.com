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
        $base_asset = explode('/', $this->trading_pair_normalized)[0];

        return [
            'buyer' => ($base_asset === $this->backward_asset) ? $this->tx0_address : $this->tx1_address,
            'seller' => ($base_asset === $this->backward_asset) ? $this->tx1_address : $this->tx0_address,
            'quantity' => ($base_asset === $this->backward_asset) ? $this->backward_quantity_normalized : $this->forward_quantity_normalized,
            'price' => $this->trading_price_normalized,
            'total' => ($base_asset === $this->backward_asset) ? $this->forward_quantity_normalized : $this->backward_quantity_normalized,
        ];
    }
}



        'block_index',
        'match_expire_index',
        'tx0_block_index',
        'tx0_index',
        'tx0_hash',
        'tx0_address',
        'tx0_expiration',
        'tx1_block_index',
        'tx1_index',
        'tx1_hash',
        'tx1_address',
        'tx1_expiration',
        'id',
        'status',
        'backward_asset',
        'backward_quantity',
        'forward_asset',
        'forward_quantity',
        'fee_paid',
        'confirmed_at',