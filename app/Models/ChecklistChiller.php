<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistChiller extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'tb_eng_checklist_chiller';
    protected $primaryKey = 'id_checklist_chiller';

    protected $fillable = [
        'id_checklist_chiller',
        'id_bsrcode',
        'hari_tanggal',
        'subject',
        'dsg',
        'dmt',
        'checktime',
    ];

    protected $dates = ['deleted_at'];

}
