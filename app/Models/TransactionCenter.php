<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionCenter extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tb_transaction_center';

    protected $fillable = [
        'id_sites',
        'no_invoice',
        'transaction_type',
        'no_transaction',
        'admin_fee',
        'sub_total',
        'total',
        'id_user',
        'status',
        'snap_token'
    ];
}
