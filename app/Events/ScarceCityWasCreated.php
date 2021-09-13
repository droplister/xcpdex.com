<?php

namespace App\Events;

use App\ScarceCity;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScarceCityWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * ScarceCity
     *
     * @var \App\ScarceCity
     */
    public $scarce_city;

    /**
     * Create a new event instance.
     * 
     * @param  \App\ScarceCity  $scarce_city
     * @return void
     */
    public function __construct(ScarceCity $scarce_city)
    {
        $this->scarce_city = $scarce_city;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('scarcecity-channel');
    }
}