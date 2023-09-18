<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquiqmentEngineeringDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_equiqment_engineering_detail';

    protected $primaryKey = 'id_equiqment_engineering_detail';

    protected $fillable = [
        'id_equiqment_engineering_detail',
        'id_equiqment_engineering',
        'image',
        'id_room',
        'status',
        'id_equiqment',
        'id_role',
        'tgl_checklist',
        'time_checklist',
        'status_checklist',
        'keterangan'
    ];

    protected $dates = ['deleted_at'];

    public function Equipment()
    {
        return $this->hasOne(EquiqmentAhu::class, 'id_equiqment_engineering', 'id_equiqment_engineering');
    }

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function Role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }
}
