<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BlockResource extends Resource
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
            'block_index' => $this->block_index,
            'orders_count' => $this->orders_count,
            'cancels_count' => $this->cancels_count,
            'order_matches_count' => $this->order_matches_count,
            'date' => $this->confirmed_at->toDateTimeString(),
        ];
    }
}
