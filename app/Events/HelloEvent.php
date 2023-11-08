<?php

namespace App\Events;

use App\Helpers\ConnectionDB;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Helpers\FCM as FcmNotification;

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
        $dataNotif = $this->dataNotif;

        if (!isset($dataNotif['connection'])) {
            $connNotif = ConnectionDB::setConnection(new Notifikasi());
        } else {
            $connNotif = new Notifikasi();
            $connNotif = $connNotif->setConnection($dataNotif['connection']);
        }

        // $notif = $connNotif->where('models', $dataNotif['models'])
        //     ->where('is_read', 0)
        //     ->where('division_receiver', $dataNotif['division_receiver'])
        //     ->orWhere('receiver', $dataNotif['receiver'])
        //     ->where('id_data', $dataNotif['id_data'])
        //     ->first();

        // if (!$notif) {
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
        // }
        $this->dataNotif['id'] = $notif->id;
        $this->FCM($dataNotif);
    }

    function FCM($dataNotif)
    {
        if (!isset($dataNotif['connection'])) {
            $connUser = ConnectionDB::setConnection(new User());
        } else {
            $connUser = new User();
            $connUser = $connUser->setConnection($dataNotif['connection']);
        }

        $work_relation = $dataNotif['division_receiver'];

        $users = $connUser->where('deleted_at', null)->whereHas('RoleH.WorkRelation', function ($q) use ($work_relation) {
            $q->where('work_relation_id', $work_relation);
        })->where('fcm_token', '!=', null)
            ->get(['login_user', 'fcm_token']);

        $sender = $connUser->where('id_user', $dataNotif['sender'])->first();
        $userReceiver = $connUser->where('id_user', $dataNotif['receiver'])->first();

        if ($dataNotif['division_receiver'] && $dataNotif['receiver']) {
            foreach ($users as $user) {
                $this->sendFCMNotification($sender, $dataNotif, $user);
            }
            $this->sendFCMNotification($sender, $dataNotif, $userReceiver);
        } elseif ($dataNotif['division_receiver'] && !$dataNotif['receiver']) {
            foreach ($users as $user) {
                $this->sendFCMNotification($sender, $dataNotif, $user);
            }
        } else {
            $this->sendFCMNotification($sender, $dataNotif, $userReceiver);
        }
    }

    function sendFCMNotification($sender, $dataNotif, $userReceiver)
    {
        $mobile_notif = new FcmNotification();
        $mobile_notif->setPayload([
            'title' => $sender ? $sender->nama_user : 'Proapps',
            'body' => $dataNotif['notif_message'] . ' ' .  $dataNotif['notif_title'],
            'token' => $userReceiver->fcm_token,
        ])->send();
    }
}
