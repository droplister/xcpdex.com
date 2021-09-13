<?php

namespace App;

use App\Events\ScarceCityWasCreated;
use Illuminate\Database\Eloquent\Model;

class ScarceCity extends Model
{

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ScarceCityWasCreated::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permalink',
        'asset',
        'price_btc',
        'price_usd',
        'timestamp',
    ];
}
