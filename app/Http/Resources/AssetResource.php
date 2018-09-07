<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AssetResource extends Resource
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
            'asset_name' => $this->asset_name,
            'display_name' => $this->display_name,
        ];
    }
}
