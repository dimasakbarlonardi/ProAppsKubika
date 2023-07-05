<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailGIGO extends Model
{
    use HasFactory;

    protected $table = 'tb_request_gigo_d';

    protected $fillable = [
        'id_request_gigo',
        'nama_barang',
        'jumlah_barang',
        'keterangan',
    ];
}
