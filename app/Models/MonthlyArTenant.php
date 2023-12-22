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
        'tgl_bayar_utility',
        'tgl_bayar_ipl',
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function CashReceipt()
    {
        return $this->hasOne(CashReceipt::class, 'id_monthly_ar_tenant', 'id_monthly_ar_tenant');
    }

    public function CashReceipts()
    {
        return $this->hasMany(CashReceipt::class, 'id_monthly_ar_tenant', 'id_monthly_ar_tenant');
    }

    public function CashReceiptsSP1()
    {
        $cr = ConnectionDB::setConnection(new CashReceipt())
            ->whereHas('MonthlyARTenant', function ($q) {
                $q->where('sp1', '!=', null);
            })
            ->where('id_unit', $this->id_unit)
            ->get();

        return $cr;
    }

    public function SplitCashReceipt($utility, $ipl)
    {
        $cr = ConnectionDB::setConnection(new CashReceipt());

        if ($ipl) {
            $cr = $cr->where('id_monthly_ipl', $ipl)->first();
        } else {
            $cr = $cr->where('id_monthly_utility', $utility)->first();
        }

        return $cr;
    }

    public function UtilityCashReceipt()
    {
        return $this->hasOne(CashReceipt::class, 'id_monthly_utility', 'id_monthly_utility');
    }

    public function IPLCashReceipt()
    {
        return $this->hasOne(CashReceipt::class, 'id_monthly_ipl', 'id_monthly_ipl');
    }

    public function OtherCashReceipt()
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $cr = $connCR->where('transaction_type', 'MonthlyOtherBillTenant')
            ->where('id_monthly_ar_tenant', $this->id_monthly_ar_tenant)
            ->first();

        return $cr;
    }

    public function CronOtherCashReceipt($db_name)
    {
        $connCR = new CashReceipt();
        $connCR = $connCR->setConnection($db_name);

        $cr = $connCR->where('transaction_type', 'MonthlyOtherBillTenant')
            ->where('id_monthly_ar_tenant', $this->id_monthly_ar_tenant)
            ->first();

        return $cr;
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

    // public function PreviousMonthBill()
    // {
    //     $prevMonthBill = ConnectionDB::setConnection(new CashReceipt())
    //         ->where('periode_bulan', '<', $this->periode_bulan)
    //         ->where('periode_tahun', $this->periode_tahun)
    //         ->with(['MonthlyUtility.ElectricUUS', 'MonthlyUtility.WaterUUS'])
    //         ->where('tgl_bayar_invoice', null)
    //         ->where('id_unit', $this->id_unit)
    //         ->get();

    //     return $prevMonthBill;
    // }

    public function PreviousMonthBillSP($biaya_lain)
    {
        $prevMonthBill = ConnectionDB::setConnection(new MonthlyArTenant())
            ->where('periode_bulan', '<', $this->periode_bulan)
            ->where('periode_tahun', $this->periode_tahun)
            ->with(['MonthlyUtility.ElectricUUS', 'MonthlyUtility.WaterUUS'])
            ->where('tgl_bayar_utility', null)
            ->orWhere('tgl_bayar_ipl', null)
            ->where('id_unit', $this->id_unit);

        if ($biaya_lain == 1) {
            $prevMonthBill = $prevMonthBill->orWhere('tgl_bayar_lainnya', null);
        }

        $prevMonthBill = $prevMonthBill->get();

        return $prevMonthBill;
    }

    public function PreviousMonthBillbyMonth($month, $year)
    {
        $prevMonthBill = ConnectionDB::setConnection(new CashReceipt())
            ->whereHas('MonthlyARTenant', function ($q) use ($month, $year) {
                $q->where('periode_bulan', $month);
                $q->where('periode_tahun', $year);
            })
            ->where('id_unit', $this->id_unit)
            ->orderBy('id', 'DESC')
            ->first();

        // dd($prevMonthBill);
        return $prevMonthBill;
    }

    // public function SubTotal()
    // {
    //     $prevMonthBill = ConnectionDB::setConnection(new MonthlyArTenant())
    //         ->where('periode_bulan', '<=', $this->periode_bulan)
    //         ->where('periode_tahun', $this->periode_tahun)
    //         ->where('tgl_bayar_invoice', null)
    //         ->get();

    //     $total_denda = $prevMonthBill->sum('total_denda');
    //     $total_tagihan_ipl = $prevMonthBill->sum('total_tagihan_ipl');
    //     $total_tagihan_utility = $prevMonthBill->sum('total_tagihan_utility');

    //     $subtotal = $total_denda + $total_tagihan_ipl + $total_tagihan_utility;

    //     return $subtotal;
    // }

    public function TenantUnit()
    {
        return $this->hasMany(TenantUnit::class, 'id_unit', 'id_unit');
    }

    public function NotifSP1($title)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $notif = $connNotif->where('notif_message', 'Surat Peringatan 1')
            ->where('notif_title', $title)
            ->first();

        return $notif;
    }

    public function NotifSP2($title)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $notif = $connNotif->where('notif_message', 'Surat Peringatan 2')
            ->where('notif_title', $title)
            ->first();

        return $notif;
    }

    public function NotifSP3($title)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $notif = $connNotif->where('notif_message', 'Surat Peringatan 3')
            ->where('notif_title', $title)
            ->first();

        return $notif;
    }

    public function NotifSPFinal($title)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $notif = $connNotif->where('notif_message', 'Surat Pemberitahuan Terakhir')
            ->where('notif_title', $title)
            ->first();

        return $notif;
    }

    public function LastBill()
    {
        $lastBill = ConnectionDB::setConnection(new MonthlyArTenant())
            ->where('tgl_bayar_utility', null)
            ->orWhere('tgl_bayar_ipl', null)
            ->orWhere('tgl_bayar_lainnya', null)
            ->where('id_unit', $this->id_unit)
            ->orderBy('id_monthly_ar_tenant', 'DESC')
            ->first();

        return $lastBill;
    }

    // public function getUtilityBilling()
    // {
    //     $connCR = ConnectionDB::setConnection(new CashReceipt());

    //     return $this->hasMany(Cas)
    // }

    protected $dates = ['deleted_at'];
}
