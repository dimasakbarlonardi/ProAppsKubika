<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistPompaSumpitDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_pompasumpit_d';
    protected $primaryKey = 'id_eng_pompa_sumpit';

    protected $fillable = [
        'id_eng_pompa_sumpit',
        'no_checklist_pompa_sumpit',
        'check_point1',
        'check_point2',
        'check_point3',
        'check_point4',
        'check_point5',
        'check_point6',
        'check_point7',
        'keterangan'
     
    ];
    protected $dates = ['deleted_at'];
}
