<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jenis_request';
    protected $primaryKey = 'id_jenis_request';

    protected $fillable = [
        'id_jenis_request',
        'jenis_request',
    ];

    protected $dates = ['deleted_at'];
}
