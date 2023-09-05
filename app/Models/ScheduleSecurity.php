<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleSecurity extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tb_schedule_security';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_room',
        'schedule',
        'status_schedule',
    ];

    protected $dates = ['deleted_at'];

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room','id_room');
    }
}
