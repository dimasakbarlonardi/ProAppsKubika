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
        'id_shift',
    ];

    protected $dates = ['deleted_at'];

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room','id_room');
    }

    public function floor()
    {
        return $this->hasOne(Floor::class, 'id_lantai', 'id_lantai');
    }

    public function Shift()
    {
        return $this->hasOne(ParameterShiftSecurity::class, 'id','id_shift');
    }

    public function Schedule()
    {
        return $this->hasOne(ChecklistSecurity::class, 'id_parameter_security', 'id');
    }

    public function Inspection()
    {
        return $this->hasMany(ChecklistParameterEquiqment::class, 'id_item', 'id')
            ->where('id_equiqment', 3);
    }


}
