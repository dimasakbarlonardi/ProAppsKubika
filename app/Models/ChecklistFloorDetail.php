<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistFloorDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_floor_d';
    protected $primaryKey = 'id_eng_floor';

    protected $fillable = [
        'id_eng_floor',
        'no_checklist_floor',
        'check_point',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
