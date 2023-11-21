<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentHousekeepingDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_equipment_housekeeping_detail';

    protected $primaryKey = 'id_equipment_housekeeping_detail';

    protected $fillable = [
        'id_equipment_housekeeping_detail',
        'id_equipment_housekeeping',
        'image',
        'id_room',
        'id_equiqment',
        'status',
        'checklist_datetime',
        'schedule',
        'status_schedule',
        'user_id'
    ];

    public function Equipment()
    {
        return $this->hasOne(EquiqmentToilet::class, 'id_equipment_housekeeping', 'id_equipment_housekeeping');
    }

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function Floor()
    {
        return $this->hasOne(Floor::class, 'id_lantai', 'id_room');
    }

    public function Role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }

    public function Schedule()
    {
        return $this->hasOne(EquiqmentToilet::class, 'id_equipment_housekeeping', 'id_equipment_housekeeping');
    }

    public function CheckedBy()
    {
        return $this->hasOne(User::class, 'id_user', 'user_id');
    }
}
