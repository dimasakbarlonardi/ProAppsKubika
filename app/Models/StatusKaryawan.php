<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusKaryawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_status_karyawan';
    protected $primaryKey = 'id_status_karyawan';

    protected $fillable = [
        'id_status_karyawan',
        'status_karyawan',
    ];
    
    protected $dates = ['deleted_at'];
}
