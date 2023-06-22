<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistPutrDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_putr_d';
    protected $primaryKey = 'id_eng_putr';

    protected $fillable = [
        'id_eng_putr',
        'no_checklist_putr',
        'check_point1',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
