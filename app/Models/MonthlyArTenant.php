<?php

namespace App\Models;

use App\Helpers\ConnectionDB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Symfony\Component\VarDumper\Server\Connection;

class MonthlyArTenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_fin_monthly_ar_tenant';

    protected $primaryKey = 'id_monthly_ar_tenant';

    protected $fillable = [
        'id_site',
        'id_unit',
        'no_monthly_invoice',
        'periode_bulan',
        'periode_tahun',
        'total_tagihan_ipl',
        'total_tagihan_utility',
        'jml_hari_jt',
        'total_denda',
        'biaya_lain',
        'total',
        'tgl_jt_invoice',
        'tgl_bayar_invoice',
        'id_monthly_utility',
        'id_monthly_ipl',
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function CashReceipt()
    {
        return $this->hasOne(CashReceipt::class, 'no_reff', 'no_monthly_invoice');
    }

    public function MonthlyIPL()
    {
        return $this->hasOne(MonthlyIPL::class, 'id', 'id_monthly_ipl');
    }

    public function MonthlyUtility()
    {
        return $this->hasOne(MonthlyUtility::class, 'id', 'id_monthly_utility');
    }

    public function NextMonthBill()
    {
        $currentMonth = $this->MonthlyIPL()->first();

        $nextMonth = (int) $currentMonth->periode_bulan + 1;
        $nextMonth = '0' . $nextMonth;

        $connNextMonth = ConnectionDB::setConnection(new MonthlyArTenant());
        $nextMonthBill = $connNextMonth->where('periode_bulan', $nextMonth)->first();

        return $nextMonthBill;
    }

    public function PreviousMonthBill()
    {
        $prevMonthBill = ConnectionDB::setConnection(new MonthlyArTenant())
        ->where('periode_bulan', '<', $this->periode_bulan)
        ->where('periode_tahun', $this->periode_tahun)
        ->where('tgl_bayar_invoice', null)
        ->get();

        return $prevMonthBill;
    }

    public function SubTotal()
    {
        $prevMonthBill = ConnectionDB::setConnection(new MonthlyArTenant())
        ->where('periode_bulan', '<=', $this->periode_bulan)
        ->where('periode_tahun', $this->periode_tahun)
        ->where('tgl_bayar_invoice', null)
        ->get();

        $total_denda = $prevMonthBill->sum('total_denda');
        $total_tagihan_ipl = $prevMonthBill->sum('total_tagihan_ipl');
        $total_tagihan_utility = $prevMonthBill->sum('total_tagihan_utility');

        $subtotal = $total_denda + $total_tagihan_ipl + $total_tagihan_utility;

        return $subtotal;
    }

    protected $dates = ['deleted_at'];
}
