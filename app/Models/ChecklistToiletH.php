<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistToiletH extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_toilet_h';
    protected $primaryKey = 'id_eng_checklist_toilet';

    protected $fillable = [
        'id_eng_checklist_toilet',
        'barcode_room',
        'id_equiqment_toilet',
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'id_role',
        'no_checklist_toilet',
    ];
    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room','id_room');
    }

    public function equiqment()
    {
        return $this->hasOne(EquiqmentToilet::class, 'id_equiqment_toilet', 'id_equiqment_toilet');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }
}
