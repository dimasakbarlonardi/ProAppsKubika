<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistChillerH extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_chiller_h';
    protected $primaryKey = 'id_eng_checklist_chiller';

    protected $fillable = [
        'id_eng_checklist_chiller',
        'barcode_room',
        'id_equiqment_chiller',
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'id_role',
        'no_checklist_chiller',
    ];
    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function equiqment()
    {
        return $this->hasOne(EquiqmentChiller::class, 'id_equiqment_chiller', 'id_equiqment_chiller');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }
}
