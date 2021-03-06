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
        'Droplister\XcpCore\App\Events\OrderWasCreated' => [
            'App\Listeners\MarketListener',
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
