<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisKendaraan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jenis_vehicle';
    protected $primaryKey = 'id_jenis_kendaraan';
    public $incrementing = false;

    protected $fillable = [
        'id_jenis_kendaraan',
        'jenis_kendaraan',
    ];

    protected $dates = ['deleted_at'];

}
