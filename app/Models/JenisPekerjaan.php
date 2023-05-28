<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisPekerjaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jenis_pekerjaan';
    protected $primaryKey = 'id_jenis_pekerjaan';

    protected $fillable = ([
        'jenis_pekerjaan',
    ]);

    protected $dates = ['deleted_at'];
}
