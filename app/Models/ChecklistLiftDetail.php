<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistLiftDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_toilet_d';
    protected $primaryKey = 'id_eng_lift';

    protected $fillable = [
        'id_eng_lift',
        'no_checklist_lift',
        'check_point',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}