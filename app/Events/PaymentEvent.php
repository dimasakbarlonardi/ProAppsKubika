<?php

namespace App\Events;

use App\Helpers\ConnectionDB;
use App\Models\Approve;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dataNotif;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($dataNotif)
    {
        $this->dataNotif = $dataNotif;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('payment-channel');
    }

    public function broadcastWith()
    {
        return $this->dataNotif;
    }
}
