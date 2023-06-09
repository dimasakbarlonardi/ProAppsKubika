<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngChiller extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_chiller';
    protected $primaryKey = 'id_eng_chiller';

    protected $fillable = [
        'id_eng_chiller',
        'nama_eng_chiller',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
