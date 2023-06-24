<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistTemperaturDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_temperatur_d';
    protected $primaryKey = 'id_eng_temperatur';

    protected $fillable = [
        'id_eng_solar',
        'no_checklist_suhu',
        'check_point1',
        'check_point2',
        'check_point3',
        'check_point4',
        'check_point5',
        'check_point6',
        'jam',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
