<?php

namespace App\Models;

use App\Helpers\ConnectionDB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyArTenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_fin_monthly_ar_tenant';

    protected $primaryKey = 'id_monthly_ar_tenant';

    protected $fillable = [
        'id_site',
        'id_tower',
        'id_unit',
        'id_tenant',
        'no_monthly_invoice',
        'periode_bulan',
        'periode_tahun',
        'total_tagihan_ipl',
        'total_tagihan_utility',
        'jml_hari_jt',
        'total_denda',
        'biaya_lain',
        'tgl_jt_invoice',
        'tgl_bayar_invoice',
        'id_eng_listrik',
        'id_eng_air',
        'id_monthly_ipl',
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function Tenant()
    {
        return $this->hasOne(Tenant::class, 'id_tenant', 'id_tenant');
    }

    public function CashReceipt()
    {
        return $this->hasOne(CashReceipt::class, 'no_reff', 'no_monthly_invoice');
    }

    public function ElectricUSS()
    {
        return $this->hasOne(ElectricUUS::class, 'id', 'id_eng_listrik');
    }

    public function WaterUSS()
    {
        return $this->hasOne(WaterUUS::class, 'id', 'id_eng_air');
    }

    public function MonthlyIPL()
    {
        return $this->hasOne(MonthlyIPL::class, 'id', 'id_monthly_ipl');
    }

    protected $dates = ['deleted_at'];
}
