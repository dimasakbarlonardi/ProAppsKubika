<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistListrikDetail extends Model
{
        use HasFactory, SoftDeletes;

        protected $table = 'tb_eng_checklist_listrik_d';
        protected $primaryKey = 'id_eng_listrik';

        protected $fillable = [
            'id_eng_listrik',
            'no_checklist_listrik',
            'nilai',
            'hasil',
            'keterangan',
        ];
        protected $dates = ['deleted_at'];
}
