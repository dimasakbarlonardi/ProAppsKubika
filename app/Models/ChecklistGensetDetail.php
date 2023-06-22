<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistGensetDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_genset_d';
    protected $primaryKey = 'id_eng_genset';

    protected $fillable = [
        'id_eng_genset',
        'no_checklist_genset',
        'check_point1',
        'check_point2',
        'check_point3',
        'check_point4',
        'check_point5',
        'check_point6',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
