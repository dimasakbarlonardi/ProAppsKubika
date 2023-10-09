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

class HelloEvent implements ShouldBroadcast
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
        return new Channel('hello-channel');
    }

    public function broadcastWith()
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $dataNotif = $this->dataNotif;

        $notif = $connNotif->where('models', $dataNotif['models'])
        ->where('is_read', 0)
        ->where('id_data', $dataNotif['id_data'])
        ->first();

        if (!$notif) {
            $notif = $connNotif;
            $notif->sender = $dataNotif['sender'];
            $notif->division_receiver = $dataNotif['division_receiver'];
            $notif->receiver = $dataNotif['receiver'];
            $notif->is_read = 0;
            $notif->id_data = $dataNotif['id_data'];
            $notif->notif_title = $dataNotif['notif_title'];
            $notif->notif_message = $dataNotif['notif_message'];
            $notif->models = $dataNotif['models'];
            $notif->save();
        }
    }
}
