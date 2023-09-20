<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquiqmentToilet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_equipment_toilet';
    protected $primaryKey = 'id_equipment_housekeeping';

    protected $fillable = [
        'id_equipment_housekeeping',
        'id_equiqment',
        'barcode_room',
        'no_equipment',
        'equipment',
        'id_role',
        'id_room',
        'schedule',
        'status_schedule'
    ];

    protected $dates = ['deleted_at'];

    public function equiqment()
    {
        return $this->hasOne(ChecklistToiletH::class, 'id_equiqment_toilet', 'id_equiqment_toilet');
    }

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }

    public function Inspection()
    {
        return $this->hasMany(ChecklistParameterEquiqment::class, 'id_item', 'id_equipment_housekeeping')
            ->where('id_equiqment', 2);
    }
}
