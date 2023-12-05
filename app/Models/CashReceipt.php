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
        'transaction_id',
        'status_message',
        'status_code',
        'signature_key',
        'settlement_time',
        'payment_type',
        'bank',
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
        'currency',
        'id_user',
        'transaction_type',
        'id_monthly_utility',
        'id_monthly_ipl'
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
        return $this->hasOne(MonthlyArTenant::class, 'no_monthly_invoice', 'no_reff');
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

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_invoice', 'no_invoice');
    }

    public function Installments()
    {
        return $this->hasMany(Installment::class, 'no_invoice', 'no_invoice');
    }

    public function Installment($bulan, $tahun)
    {
        $connInstallment = ConnectionDB::setConnection(new Installment());

        $installment = $connInstallment->where('periode', $bulan)
            ->where('tahun', $tahun)
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
}
