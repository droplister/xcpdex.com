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
        $base_asset = Asset::where('asset_name', '=', explode('/', $this->trading_pair_normalized)[0])
            ->orWhere('asset_longname', '=', explode('/', $this->trading_pair_normalized)[0])
            ->first();

        return [
            (float) $this->trading_price_normalized,
            ($base_asset->asset_name === $this->get_asset) ? (float) $this->get_remaining_normalized : (float) $this->give_remaining_normalized,
        ];
    }
}