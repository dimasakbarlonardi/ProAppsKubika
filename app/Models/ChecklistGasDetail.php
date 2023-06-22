<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistGasDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_gas_d';
    protected $primaryKey = 'id_eng_gas';

    protected $fillable = [
        'id_eng_gas',
        'no_checklist_gas',
        'data1',
        'data2',
        'data3',
        'data4',
        'total1',
        'total2',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
