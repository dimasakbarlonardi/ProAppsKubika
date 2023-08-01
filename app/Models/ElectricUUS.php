<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElectricUUS extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_monthly_meter_listrik';

    protected $fillable = [
        'periode_bulan',
        'periode_tahun',
        'id_unit',
        'nomor_listrik_awal',
        'nomor_listrik_akhir',
        'usage',
        'id_user',
        'no_refrensi',
        'catatan',
        'is_approve'
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function CR()
    {
        return $this->hasOne(CashReceipt::class, 'no_reff', 'no_refrensi');
    }

    public function dataByMonthYear($month, $year)
    {
        return $this->hasOne(WaterUUS::class, 'id_unit', 'id_unit')
        ->where('periode_bulan', $month)
        ->where('periode_tahun', $year)->first();
    }

    protected $dates = ['deleted_at'];
}
