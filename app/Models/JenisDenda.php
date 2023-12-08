<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisDenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jenis_denda';

    protected $primaryKey = 'id_jenis_denda';

    protected $fillable = [
        'id_jenis_denda',
        'jenis_denda',
        'denda_flat_procetage',
        'denda_flat_amount',
        'is_active',
        'unity'
    ];

    protected $dates = ['deleted_at'];

    function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        echo $hasil_rupiah;

    }
}
