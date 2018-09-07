<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DepthResource extends Resource
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
            (float) $this->trading_price_normalized,
            (float) ($base_asset === $this->get_asset) ? $this->get_remaining_normalized : $this->give_remaining_normalized,
        ];
    }
}