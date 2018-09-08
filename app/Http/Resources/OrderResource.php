<?php

namespace App\Http\Resources;

use Droplister\XcpCore\App\Asset;
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
        $base_asset = explode('/', $this->trading_pair_normalized)[0];
        $base_asset = Asset::find($base_asset);
        $quote_asset = explode('/', $this->trading_pair_normalized)[1];
        $quote_asset = Asset::find($quote_asset);

        return [
            'tx_hash' => $this->tx_hash,
            'date' => $this->confirmed_at->toDateTimeString(),
            'market' => str_replace('/', '_', $this->trading_pair_normalized),
            'base_asset' => $base_asset->display_name,
            'quote_asset' => $quote_asset->display_name,
            'source' => $this->source,
            'price' => $this->trading_price_normalized,
            'quantity' => ($base_asset->asset_name === $this->get_asset) ? $this->get_remaining_normalized : $this->give_remaining_normalized,
            'total' => ($base_asset->asset_name === $this->get_asset) ? $this->give_remaining_normalized : $this->get_remaining_normalized,
        ];
    }
}