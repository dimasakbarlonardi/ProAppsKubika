<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistKoridorDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_koridor_d';
    protected $primaryKey = 'id_eng_koridor';

    protected $fillable = [
        'id_eng_koridor',
        'no_checklist_koridor',
        'check_point',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
