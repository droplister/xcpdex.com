<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Droplister\XcpCore\App\Events\BlockWasCreated' => [
            'App\Listeners\BlockListener',
        ],
        'Droplister\XcpCore\App\Events\DispenseWasCreated' => [
            'App\Listeners\DispenseListener',
        ],
        'Droplister\XcpCore\App\Events\DispenserWasCreated' => [
            'App\Listeners\DispenserListener',
        ],
        'App\Events\OpenSeaWasCreated' => [
            'App\Listeners\OpenSeaListener',
        ],
        'Droplister\XcpCore\App\Events\OrderWasCreated' => [
            'App\Listeners\OrderListener',
            'App\Listeners\MarketListener',
        ],
        'Droplister\XcpCore\App\Events\OrderMatchWasCreated' => [
            'App\Listeners\OrderMatchListener',
        ],
        'Droplister\XcpCore\App\Events\IssuancesWasCreated' => [
            'App\Listeners\IssuanceListener',
        ],
        'App\Events\ScarceCityWasCreated' => [
            'App\Listeners\ScarceCityListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
