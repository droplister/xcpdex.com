<?php

namespace App;

use Cache;
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
        'last_price',
        'last_trade_date',
        'base_asset_supply',
        'base_asset_display_name',
        'quote_asset_display_name',
        'volume',
        'market_cap',
        'orders_count',
        'open_orders_count',
        'order_matches_count',
    ];

    /**
     * Volume Normalized
     *
     * @return string
     */
    public function getVolumeNormalizedAttribute()
    {
        return Cache::remember('m_vn_' . $this->slug, 1440, function () {
            return normalizeQuantity($this->volume, $this->quoteAsset->divisible);
        });
    }

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
     * Last Match
     * 
     * @return \Droplister\XcpCore\App\OrderMatch
     */
    public function lastMatch()
    {
        return OrderMatch::where('backward_asset', '=', $this->xcp_core_base_asset)
            ->where('forward_asset', '=', $this->xcp_core_quote_asset)
            ->where('status', '=', 'completed')
            ->orWhere('backward_asset', '=', $this->xcp_core_quote_asset)
            ->where('forward_asset', '=', $this->xcp_core_base_asset)
            ->where('status', '=', 'completed')
            ->orderBy('tx1_index', 'desc')
            ->first();
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