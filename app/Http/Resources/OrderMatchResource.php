<?php

namespace App\Http\Resources;

use Droplister\XcpCore\App\Asset;
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
        $base_asset = Asset::where('asset_name', '=', explode('/', $this->trading_pair_normalized)[0])
            ->orWhere('asset_longname', '=', explode('/', $this->trading_pair_normalized)[0])
            ->first();

        $quote_asset = Asset::where('asset_name', '=', explode('/', $this->trading_pair_normalized)[1])
            ->orWhere('asset_longname', '=', explode('/', $this->trading_pair_normalized)[1])
            ->first();

        return [
            'tx_hash' => $this->tx1_hash,
            'base_asset' => $base_asset->display_name,
            'quote_asset' => $quote_asset->display_name,
            'market' => $this->trading_pair_normalized,
            'market_slug' => str_replace('/', '_', $this->trading_pair_normalized),
            'date' => $this->confirmed_at->toDateTimeString(),
            'buyer' => ($base_asset->asset_name === $this->backward_asset) ? $this->tx0_address : $this->tx1_address,
            'seller' => ($base_asset->asset_name === $this->backward_asset) ? $this->tx1_address : $this->tx0_address,
            'price' => $this->trading_price_normalized,
            'quantity' => ($base_asset->asset_name === $this->backward_asset) ? $this->backward_quantity_normalized : $this->forward_quantity_normalized,
            'total' => ($base_asset->asset_name === $this->backward_asset) ? $this->forward_quantity_normalized : $this->backward_quantity_normalized,
        ];
    }
}