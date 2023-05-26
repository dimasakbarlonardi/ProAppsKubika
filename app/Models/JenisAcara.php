<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisAcara extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jenis_acara';
    protected $primaryKey = 'id_jenis_acara';

    protected $fillable = [
        'id_jenis_acara',
        'jenis_acara',
    ];

    protected $dates = ['deleted_at'];  
}
