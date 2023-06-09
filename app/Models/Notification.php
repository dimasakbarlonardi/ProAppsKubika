<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    
    public function idusers()
    {
        return $this->hasOne(Login::class, 'id', 'id_user');
    }
}
