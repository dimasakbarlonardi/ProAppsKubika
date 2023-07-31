<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashReceiptDetail extends Model
{
    use HasFactory;

    protected $table = 'tb_draft_cash_receipt_d';

    protected $fillable = [
        'no_draft_cr',
        'class_code',
        'ket_transaksi',
        'dc',
        'tx_amount',
    ];
}
