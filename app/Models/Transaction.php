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

    public function User()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function WorkOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'no_work_order', 'no_transaction');
    }
}
