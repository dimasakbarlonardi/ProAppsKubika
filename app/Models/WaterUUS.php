<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterUUS extends Model
{
    use HasFactory;

    protected $table = 'tb_eng_monthly_meter_air';

    protected $fillable = [
        'periode_bulan',
        'periode_tahun',
        'id_unit',
        'nomor_air_awal',
        'nomor_air_akhir',
        'id_user',
        'no_refrensi',
        'catatan',
        'is_approve'
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    protected $dates = ['deleted_at'];
}
