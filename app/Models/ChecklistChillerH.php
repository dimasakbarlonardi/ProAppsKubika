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
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'id_user',
        'no_checklist_chiller',
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

    public function engahu()
    {
        return $this->hasOne(EngAhu::class, 'id_eng_ahu', 'id_eng_ahu');
    }
}
