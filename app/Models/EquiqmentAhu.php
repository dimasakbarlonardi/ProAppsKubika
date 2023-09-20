<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquiqmentAhu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_equiqment_ahu';
    protected $primaryKey = 'id_equiqment_engineering';

    protected $fillable = [
        'id_equiqment_engineering',
        'id_equiqment',
        'barcode_room',
        'no_equiqment',
        'equiqment',
        'id_role',
        'id_room',
        'schedule',
        'status_schedule',
    ];

    protected $dates = ['deleted_at'];

    public function equiqment()
    {
        return $this->hasOne(ChecklistAhuH::class, 'id_equiqment_ahu', 'id_equiqment_ahu');
    }

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function Schedule()
    {
        return $this->hasOne(EquiqmentEngineeringDetail::class, 'id_equiqment_engineering', 'id_equiqment_engineering');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }

    public function InspectionEng()
    {
        return $this->hasMany(ChecklistParameterEquiqment::class, 'id_item', 'id_equiqment_engineering')
            ->where('id_equiqment', 1);
    }
}
