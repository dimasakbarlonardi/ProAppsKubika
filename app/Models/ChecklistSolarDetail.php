<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistSolarDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_solar_d';
    protected $primaryKey = 'id_eng_solar';

    protected $fillable = [
        'id_eng_solar',
        'no_checklist_solar',
        'check_point1',
        'check_point2',
        'check_point3',
        'check_point4',
        'data1',
        'data2',
        'jam1',
        'jam2',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
