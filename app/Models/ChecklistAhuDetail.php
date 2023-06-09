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
        'in_out',
        'check_point',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];

}
