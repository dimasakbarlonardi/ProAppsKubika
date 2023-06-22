<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistGroundRoofDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_groundroof_d';
    protected $primaryKey = 'id_eng_groundrooftank';

    protected $fillable = [
        'id_eng_groundrooftank',
        'no_checklist_tank',
        'check_point1',
        'check_point2',
        'check_point3',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
