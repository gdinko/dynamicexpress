<?php

namespace Gdinko\DynamicExpress\Events;

use Gdinko\DynamicExpress\Models\CarrierDynamicExpressPayment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CarrierDynamicExpressPaymentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payment;

    public $account;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CarrierDynamicExpressPayment $payment, string $account)
    {
        $this->payment = $payment;

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
