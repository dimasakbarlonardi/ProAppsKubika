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
        'status',
        'id_equipment',
        'id_role',
        'tgl_checklist',
        'time_checklist',
        'keterangan'
    ];

    public function equipment()
    {
        return $this->hasOne(EquiqmentToilet::class, 'id_equipment_housekeeping', 'id_equipment_housekeeping');
    }

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }
}