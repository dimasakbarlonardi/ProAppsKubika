<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistAhuDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_ahu_d';
    protected $primaryKey = 'id_ahu';

    protected $fillable = [
        'id_ahu',
        'no_checklist_ahu',
        'id_equiqment',
        'usage_return',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }
    
    // public function checklist()
    // {
    //     return $this->hasMany(ChecklistParameterEquiqment::class, 'id_equiqment', 'id_equiqment');
    // }

}
