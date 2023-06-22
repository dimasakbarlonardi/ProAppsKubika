<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistGasH extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_gas_h';
    protected $primaryKey = 'id_eng_checklist_gas';

    protected $fillable = [
        'id_eng_checklist_gas',
        'no_checklist_gas',
        'barcode_room',
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'id_user',
    ];
    protected $dates = ['deleted_at'];
    
    public function room()
    {
        return $this->hasOne(Room::class, 'id_room','id_room');
    }
}