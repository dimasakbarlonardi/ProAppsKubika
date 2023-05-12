<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisKelamin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jenis_kelamin';
    protected $primaryKey = 'id_jenis_kelamin';
    public $incrementing = false;

    protected $fillable = [
        'id_jenis_kelamin',
        'jenis_kelamin',
    ];
    protected $dates = ['deleted_at'];
}
