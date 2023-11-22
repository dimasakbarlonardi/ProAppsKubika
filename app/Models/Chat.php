<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'tb_chats';

    protected $fillable = [
        'room_id',
        'message',
        'receiver_id',
        'sender_id',
        'is_read'
    ];

    public function Sender()
    {
        return $this->hasOne(User::class, 'id_user', 'sender_id');
    }

    public function Receiver()
    {
        return $this->hasOne(User::class, 'id_user', 'receiver_id');
    }

    public function Room()
    {
        return $this->hasOne(RoomChat::class, 'id', 'room_id');
    }
}
