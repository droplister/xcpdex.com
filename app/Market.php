<?php

namespace App;

use Droplister\XcpCore\App\Asset;
use Droplister\XcpCore\App\Order;
use Droplister\XcpCore\App\OrderMatch;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use Sluggable, SluggableScopeHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xcp_core_base_asset',
        'xcp_core_quote_asset',
        'name',
        'slug',
    ];

    /**
     * Base Asset
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function baseAsset()
    {
        return $this->belongsTo(Asset::class, 'xcp_core_base_asset', 'asset_name');
    }

    /**
     * Quote Asset
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quoteAsset()
    {
        return $this->belongsTo(Asset::class, 'xcp_core_quote_asset', 'asset_name');
    }

    /**
     * Orders (Buys)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getOrders()
    {
        return $this->hasMany(OrderMatch::class, 'get_asset', 'xcp_core_base_asset')
                    ->where('give_asset', '=', $this->xcp_core_quote_asset);
    }

    /**
     * Orders (Sells)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function giveOrders()
    {
        return $this->hasMany(Order::class, 'give_asset', 'xcp_core_base_asset')
                    ->where('get_asset', '=', $this->xcp_core_quote_asset);
    }

    /**
     * Order Matches (Buys)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function backwardOrderMatches()
    {
        return $this->hasMany(Order::class, 'backward_asset', 'xcp_core_base_asset')
                    ->where('forward_asset', '=', $this->xcp_core_quote_asset);
    }

    /**
     * Order Matches (Sells)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forwardOrderMatches()
    {
        return $this->hasMany(OrderMatch::class, 'forward_asset', 'xcp_core_base_asset')
                    ->where('forward_asset', '=', $this->xcp_core_quote_asset);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'method' => function ($string, $separator) {
                    return str_replace('/', '_', $string);
                }
            ]
        ];
    }
}