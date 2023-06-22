<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngGas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_gas';
    protected $primaryKey = 'id_eng_gas';

    protected $fillable = [
        'id_eng_gas',
        'nama_eng_gas',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
