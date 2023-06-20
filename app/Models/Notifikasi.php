<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifikasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_notifikasi';

    protected $fillable = [
        'receiver',
        'sender',
        'is_read',
        'models',
        'id_data',
        'notif_title',
        'notif_message'
    ];

    public function Receiver()
    {
        return $this->hasOne(User::class, 'id_user', 'receiver');
    }

    public function Sender()
    {
        return $this->hasOne(User::class, 'id_user', 'sender');
    }
}
