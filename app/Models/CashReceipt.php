<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'transaction_type'
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

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_invoice', 'no_invoice');
    }
}
