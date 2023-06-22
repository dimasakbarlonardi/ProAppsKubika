<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistChillerDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_chiller_d';
    protected $primaryKey = 'id_eng_chiller';

    protected $fillable = [
        'id_eng_listrik',
        'no_checklist_listrik',
        'in_out',
        'checkpoint',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
