<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tb_transaksi';

    protected $fillable = [
        'no_invoice',
        'no_transaction',
        'admin_fee',
        'sub_total',
        'total',
        'id_user',
        'snap_token'
    ];
}
