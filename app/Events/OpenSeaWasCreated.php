<?php

namespace App\Events;

use App\OpenSea;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OpenSeaWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * OpenSea
     *
     * @var \App\OpenSea
     */
    public $open_sea;

    /**
     * Create a new event instance.
     * 
     * @param  \App\OpenSea  $open_sea
     * @return void
     */
    public function __construct(OpenSea $open_sea)
    {
        $this->open_sea = $open_sea;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('opensea-channel');
    }
}