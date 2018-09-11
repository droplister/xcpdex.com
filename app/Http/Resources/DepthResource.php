<?php

namespace App\Http\Resources;

use Droplister\XcpCore\App\Asset;
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
        return [
            (float) $this->trading_price_normalized,
            (float) $this->trading_quantity_normalized,
        ];
    }
}