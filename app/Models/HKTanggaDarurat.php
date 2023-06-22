<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HKTanggaDarurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_hk_tangga_darurat';
    protected $primaryKey = 'id_hk_tangga_darurat';

    protected $fillable = [
        'id_hk_tangga_darurat',
        'nama_hk_tangga_darurat',
        'subject',
        'periode',
    ];
    protected $dates = ['deleted_at'];
}
