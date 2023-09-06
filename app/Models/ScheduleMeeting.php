<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleMeeting extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'tb_schedule_meeting';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'meeting',
        'date',
        'id_room',
        'time_in',
        'time_out',
    ];

    protected $dates = ['deleted_at'];

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room','id_room');
    }
}
