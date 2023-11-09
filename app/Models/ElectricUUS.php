<?php

namespace App\Models;

use App\Helpers\ConnectionDB;
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
        'ppj',
        'total',
        'id_user',
        'no_refrensi',
        'catatan',
        'is_approve',
        'image'
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function WaterUUSrelation()
    {
        return ConnectionDB::setConnection(new WaterUUS())
        ->where('periode_bulan', $this->periode_bulan)
        ->where('periode_tahun', $this->periode_tahun)
        ->first();
    }

    public function MonthlyUtility()
    {
        return $this->hasOne(MonthlyUtility::class, 'id_eng_listrik', 'id');
    }

    protected $dates = ['deleted_at'];
}
