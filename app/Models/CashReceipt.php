<?php

namespace App\Models;

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
        'no_draft_cr',
        'ket_pembayaran',
        'transaction_status',
        'transaction_id',
        'status_message',
        'status_code',
        'signature_key',
        'settlement_time',
        'payment_type',
        'payment_amounts',
        'merchant_id',
        'admin_fee',
        'subtotal',
        'gross_amount',
        'fraud_status',
        'snap_token',
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
}
