<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OwnerOFF extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_pemilik_off';

    protected $fillable = [
        'id_pemilik',
        'id_site',
        'id_user',
        'tgl_masuk',
        'tgl_keluar',
        'tgl_sys',
        'keterangan',
    ];

    protected $date = ['deleted_at'];
}
