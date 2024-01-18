<?php

namespace App\Models;

use App\Helpers\ConnectionDB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class CashReceipt extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tb_draft_cash_receipt';

    protected $fillable = [
        'order_id',
        'id_site',
        'no_reff',
        'no_invoice',
        'no_draft_cr',
        'ket_pembayaran',
        'transaction_status',
        'payment_image',
        'transaction_id',
        'tgl_jt_invoice',
        'jml_hari_jt',
        'interest',
        'total_denda',
        'denda_bulan_sebelumnya',
        'settlement_time',
        'payment_type',
        'bank',
        'amount',
        'payment_amounts',
        'merchant_id',
        'admin_fee',
        'tax',
        'subtotal',
        'gross_amount',
        'fraud_status',
        'snap_token',
        'va_number',
        'expiry_time',
        'id_user',
        'id_unit',
        'transaction_type',
        'id_monthly_utility',
        'id_monthly_ipl',
        'id_monthly_ar_tenant'
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function WorkOrder()
    {
        return $this->hasOne(WorkOrder::class, 'no_work_order', 'no_reff');
    }

    public function WorkPermit()
    {
        return $this->hasOne(WorkPermit::class, 'no_work_permit', 'no_reff');
    }

    public function Reservation()
    {
        return $this->hasOne(Reservation::class, 'no_request_reservation', 'no_reff');
    }

    public function MonthlyARTenant()
    {
        return $this->hasOne(MonthlyArTenant::class, 'id_monthly_ar_tenant', 'id_monthly_ar_tenant');
    }

    public function SplitMonthlyARTenant($utility, $ipl)
    {
        $ar = ConnectionDB::setConnection(new MonthlyArTenant());

        if ($ipl) {
            $ar = $ar->where('id_monthly_ipl', $ipl)->first();
        } else {
            $ar = $ar->where('id_monthly_utility', $utility)->first();
        }

        return $ar;
    }

    public function SplitMonthlyARTenantNotif($utility, $ipl, $db)
    {
        $ar = new MonthlyArTenant();
        $ar = $ar->setConnection($db);

        if ($ipl) {
            $ar = $ar->where('id_monthly_ipl', $ipl)->first();
        } else {
            $ar = $ar->where('id_monthly_utility', $utility)->first();
        }

        return $ar;
    }

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_invoice', 'no_invoice');
    }

    public function Installments()
    {
        return $this->hasMany(Installment::class, 'no_invoice', 'no_invoice');
    }

    public function Installment()
    {
        $connInstallment = ConnectionDB::setConnection(new Installment());

        $installment = $connInstallment->where('periode', $this->MonthlyARTenant->periode_bulan)
            ->where('tahun', $this->MonthlyARTenant->periode_tahun)
            ->where('installment_type', $this->transaction_type)
            ->first();

        return $installment;
    }

    public function CronInstallment($db_name)
    {
        $connInstallment = new Installment();
        $connInstallment = $connInstallment->setConnection($db_name);

        $installment = $connInstallment->where('periode', $this->MonthlyARTenant->periode_bulan)
            ->where('tahun', $this->MonthlyARTenant->periode_tahun)
            ->where('installment_type', $this->transaction_type)
            ->first();

        return $installment;
    }

    public function UpdateInstallment($bulan, $tahun, $connection)
    {
        if (Auth::user()) {
            $connInstallment = ConnectionDB::setConnection(new Installment());
        } else {
            $connInstallment = new Installment();
            $connInstallment = $connInstallment->setConnection($connection);
        }

        $installment = $connInstallment->where('periode', $bulan)
            ->where('tahun', $tahun)
            ->first();

        return $installment;
    }

    public function PreviousMonthBill($month, $year)
    {
        $prevMonthBill = ConnectionDB::setConnection(new CashReceipt())
            ->whereHas('MonthlyARTenant', function ($q) use ($month, $year) {
                $q->where('periode_bulan', '<', $month);
                $q->where('periode_tahun', $year);
            })
            ->with(['MonthlyARTenant.MonthlyUtility.ElectricUUS', 'MonthlyARTenant.MonthlyUtility.WaterUUS'])
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $this->id_unit)
            ->get();

        return $prevMonthBill;
    }

    public function PreviousUtilityBill($month, $year)
    {
        $prevMonthBill = ConnectionDB::setConnection(new CashReceipt())
            ->whereHas('MonthlyARTenant', function ($q) use ($month, $year) {
                $q->where('periode_bulan', '<', $month);
                $q->where('periode_tahun', $year);
            })
            ->where('transaction_type', 'MonthlyUtilityTenant')
            ->with(['MonthlyARTenant.MonthlyUtility.ElectricUUS', 'MonthlyARTenant.MonthlyUtility.WaterUUS'])
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $this->id_unit)
            ->get();

        return $prevMonthBill;
    }

    public function CronPreviousUtilityBill($month, $year, $db_name)
    {
        $prevMonthBill = new CashReceipt();

        $prevMonthBill = $prevMonthBill->setConnection($db_name)
            ->whereHas('MonthlyARTenant', function ($q) use ($month, $year) {
                $q->where('periode_bulan', '<', $month);
                $q->where('periode_tahun', $year);
            })
            ->where('transaction_type', 'MonthlyUtilityTenant')
            ->with(['MonthlyARTenant.MonthlyUtility.ElectricUUS', 'MonthlyARTenant.MonthlyUtility.WaterUUS'])
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $this->id_unit)
            ->get();

        return $prevMonthBill;
    }

    public function PreviousIPLBill($month, $year)
    {
        $prevMonthBill = ConnectionDB::setConnection(new CashReceipt())
            ->whereHas('MonthlyARTenant', function ($q) use ($month, $year) {
                $q->where('periode_bulan', '<', $month);
                $q->where('periode_tahun', $year);
            })
            ->where('transaction_type', 'MonthlyIPLTenant')
            ->with(['MonthlyARTenant.MonthlyUtility.ElectricUUS', 'MonthlyARTenant.MonthlyUtility.WaterUUS'])
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $this->id_unit)
            ->get();

        return $prevMonthBill;
    }

    public function CronPreviousIPLBill($month, $year, $db_name)
    {
        $prevMonthBill = new CashReceipt();
        $prevMonthBill = $prevMonthBill->setConnection($db_name)
            ->whereHas('MonthlyARTenant', function ($q) use ($month, $year) {
                $q->where('periode_bulan', '<', $month);
                $q->where('periode_tahun', $year);
            })
            ->where('transaction_type', 'MonthlyIPLTenant')
            ->with(['MonthlyARTenant.MonthlyUtility.ElectricUUS', 'MonthlyARTenant.MonthlyUtility.WaterUUS'])
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $this->id_unit)
            ->get();

        return $prevMonthBill;
    }

    public function PreviousOtherBill($month, $year)
    {
        $prevMonthBill = ConnectionDB::setConnection(new CashReceipt())
            ->whereHas('MonthlyARTenant', function ($q) use ($month, $year) {
                $q->where('periode_bulan', '<', $month);
                $q->where('periode_tahun', $year);
            })
            ->where('transaction_type', 'MonthlyOtherBillTenant')
            ->with(['MonthlyARTenant.MonthlyUtility.ElectricUUS', 'MonthlyARTenant.MonthlyUtility.WaterUUS'])
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $this->id_unit)
            ->get();

        return $prevMonthBill;
    }

    public function CronPreviousOtherBill($month, $year, $db_name)
    {
        $prevMonthBill = new CashReceipt();
        $prevMonthBill = $prevMonthBill->setConnection($db_name)
            ->whereHas('MonthlyARTenant', function ($q) use ($month, $year) {
                $q->where('periode_bulan', '<', $month);
                $q->where('periode_tahun', $year);
            })
            ->where('transaction_type', 'MonthlyOtherBillTenant')
            ->with(['MonthlyARTenant.MonthlyUtility.ElectricUUS', 'MonthlyARTenant.MonthlyUtility.WaterUUS'])
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $this->id_unit)
            ->get();

        return $prevMonthBill;
    }

    public static function SubTotalUtility()
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $cr = $connCR->where('transaction_status', '!=', 'PAID')
            ->where('transaction_type', 'MonthlyUtilityTenant')
            ->sum('sub_total');

        return $cr;
    }

    public static function SubTotalIPL()
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $cr = $connCR->where('transaction_status', '!=', 'PAID')
            ->where('transaction_type', 'MonthlyIPLTenant')
            ->sum('sub_total');

        return $cr;
    }

    public static function SubTotalOtherBill()
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $cr = $connCR->where('transaction_status', '!=', 'PAID')
            ->where('transaction_type', 'MonthlyOtherBillTenant')
            ->sum('sub_total');

        return $cr;
    }

    public function SubTotal($month, $year)
    {
        $prevMonthBill = ConnectionDB::setConnection(new CashReceipt())
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $this->id_unit)
            ->get();

        $subtotal = $prevMonthBill->sum('sub_total');;

        return $subtotal;
    }

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }
}
