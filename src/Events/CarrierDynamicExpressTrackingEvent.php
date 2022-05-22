<?php

namespace Gdinko\DynamicExpress\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CarrierDynamicExpressTrackingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tracking;

    public $account;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $tracking, string $account)
    {
        $this->tracking = $tracking;

        $this->account = $account;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
