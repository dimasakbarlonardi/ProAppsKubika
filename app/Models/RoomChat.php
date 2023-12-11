<?php

namespace App\Models;

use App\Helpers\ConnectionDB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomChat extends Model
{
    use HasFactory;

    protected $table = 'tb_room_chats';

    protected $fillable = [
        'receiver_id',
        'sender_id'
    ];

    public function Sender()
    {
        return $this->hasOne(User::class, 'id_user', 'sender_id');
    }

    public function Receiver()
    {
        return $this->hasOne(User::class, 'id_user', 'receiver_id');
    }

    public function Chats()
    {
        return $this->hasMany(Chat::class, 'room_id', 'id');
    }

    public function LatestChat($id)
    {
        $connChat = ConnectionDB::setConnection(new Chat());

        $chat = $connChat->where('room_id', $id)->orderBy('id', 'DESC')->first();

        return $chat;
    }

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'id', 'id');
    }
}
