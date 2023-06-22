<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistPemadamDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_pemadam_d';
    protected $primaryKey = 'id_eng_pemadam';

    protected $fillable = [
        'id_eng_pemadam',
        'no_checklist_pemadam',
        'check_point1',
        'check_point2',
        'check_point3',
        'check_point4',
        'check_point5',
        'check_point6',
        'check_point7',
        'check_point8',
        'check_point9',
        'check_point10',
        'check_point11',
        'check_point12',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
