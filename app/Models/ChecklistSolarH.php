<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistSolarH extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_solar_h';
    protected $primaryKey = 'id_eng_checklist_solar';

    protected $fillable = [
        'id_eng_checklist_solar',
        'barcode_room',
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'id_user',
        'no_checklist_solar',
    ];
    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room','id_room');
    }
}
