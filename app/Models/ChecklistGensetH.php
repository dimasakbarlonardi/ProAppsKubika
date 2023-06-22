<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistGensetH extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_genset_h';
    protected $primaryKey = 'id_eng_checklist_genset';

    protected $fillable = [
        'id_eng_checklist_genset',
        'no_checklist_genset',
        'barcode_room',
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'id_user',
    ];
    protected $dates = ['deleted_at'];

    
}
