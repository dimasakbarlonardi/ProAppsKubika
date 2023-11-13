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
        'periode',
        'tahun',
        'rev',
        'status',
        'amount'
    ];
}
