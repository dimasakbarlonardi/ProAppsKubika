<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistSecurity extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tb_checklist_security';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_parameter_security',
        'id_shift',
        'id_room',
        'user_id',
        'checklist_datetime',
        'image',
        'notes',
        'status',
        'schedule',
        'status_schedule'
    ];

    protected $dates = ['deleted_at'];

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function Parameter()
    {
        return $this->hasOne(ParameterSecurity::class, 'id', 'id_parameter_security');
    }

    public function Schedule()
    {
        return $this->hasOne(ScheduleSecurity::class, 'id', 'id_parameter_security');
    }

    public function InspectionLocation()
    {
        return $this->hasOne(ScheduleSecurity::class, 'id', 'id_parameter_security');
    }

    public function Shift()
    {
        return $this->hasOne(ParameterShiftSecurity::class, 'id', 'id_shift');
    }

    public function CheckedBy()
    {
        return $this->hasOne(User::class, 'id_user', 'user_id');
    }
}
