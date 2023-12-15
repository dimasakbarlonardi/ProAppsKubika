<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $table = 'tb_installments';

    protected $fillable = [
        'no_invoice',
        'installment_type',
        'periode',
        'tahun',
        'rev',
        'status',
        'amount'
    ];

    public function CashReceipt()
    {
        return $this->hasOne(CashReceipt::class, 'no_invoice', 'no_invoice');
    }
}
