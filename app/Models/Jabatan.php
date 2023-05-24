<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jabatan';

    protected $fillable = [
        'id_jabatan',
        'nama_jabatan',
    ];
    protected $dates = ['deleted_at'];
}
