<?php

namespace App;

use App\Events\OpenSeaWasCreated;
use Illuminate\Database\Eloquent\Model;

class OpenSea extends Model
{

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => OpenSeaWasCreated::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tx_hash',
        'permalink',
        'asset',
        'image',
        'quantity',
        'trade_price_usd',
        'total_volume_usd',
        'total_volume_payment_token',
        'seller_name',
        'seller_address',
        'winner_name',
        'winner_address',
        'payment_token',
        'payment_token_decimals',
        'payment_token_eth_price',
        'payment_token_usd_price',
        'confirmed_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'confirmed_at',
    ];
}
