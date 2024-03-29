<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistAhuH extends Model
{  
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_ahu_h';
    protected $primaryKey = 'id_checklist_ahu_h';

    protected $fillable = [
        'id_checklist_ahu_h',
        'barcode_room',
        'id_equiqment_ahu',
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'id_role',
        'no_checklist_ahu',
    ];

    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function ahudetails()
    {
        return $this->hasOne(ChecklistAhuDetail::class, 'id_ahu', 'id_ahu');
    }

    public function equiqment()
    {
        return $this->hasOne(EquiqmentAhu::class, 'id_equiqment_ahu', 'id_equiqment_ahu');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }

    
}
