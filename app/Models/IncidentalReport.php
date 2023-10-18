<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentalReport extends Model
{
    use HasFactory;

    protected $table = 'tb_incidental_reports';

    protected $fillable = [
        'incident_name',
        'location',
        'incident_date',
        'incident_time',
        'incident_image',
        'desc',
        'user_id'
    ];

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room', 'room_id');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id_user', 'user_id');
    }
}
