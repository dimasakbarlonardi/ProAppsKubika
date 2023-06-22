<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_notification';

    protected $primaryKey = 'id';

    protected $fillable = [
    'id',
    'tgl_notif',
    'notification_1',
    'notification_2',
    'notif_image',
    'durasi_notif',
    'id_user',

    ];

    protected $dates = ['deleted_at'];
    
    public function user()
    {
        return $this->hasOne(User::class , 'id', 'id_user');
    }
}
