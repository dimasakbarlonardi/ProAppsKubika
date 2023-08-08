<?php

namespace App\Models;

use App\Helpers\ConnectionDB;
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

    public function ElecUUSrelation()
    {
        return ConnectionDB::setConnection(new ElectricUUS())
        ->where('periode_bulan', $this->periode_bulan)
        ->where('periode_tahun', $this->periode_tahun)
        ->first();
    }

    public function MonthlyUtility()
    {
        return $this->hasOne(MonthlyUtility::class, 'id_eng_air', 'id');
    }

    protected $dates = ['deleted_at'];
}
