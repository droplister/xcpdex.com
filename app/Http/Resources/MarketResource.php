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
            'volume' => $this->volume_normalized,
            'change' => $this->change,
            'base_asset' => $this->baseAsset->display_name,
        ];
    }
}
