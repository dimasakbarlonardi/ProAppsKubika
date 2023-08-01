<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyArTenant extends Model
{
    use HasFactory;

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
        'total_denda',
        'biaya_lain',
        'tgl_jt_invoice',
        'tgl_bayar_invoice'
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    protected $dates = ['deleted_at'];
}
