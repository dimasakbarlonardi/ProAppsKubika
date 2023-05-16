<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;
    protected $table = 'tb_system';

    protected $fillable = [
        'tgl_system',
        'id_group',
        'id_pengurus',
        'id_strata',
        'id_site',
        'kode_unik_tiket',
        'kode_unik_wr',
        'kode_unik_wo',
        'kode_unik_pr',
        'kode_unik_po',
        'kode_unik_invoice',
        'kode_unik_cash_payment',
        'kode_unik_cash_receipt',
        'sequence_notiket',
        'sequence_no_wr',
        'sequence_no_wo',
        'sequence_no_pr',
        'sequence_no_po',
        'sequence_no_invoice',
        'sequence_no_cash_payment',
        'sequence_no_cash_receiptment'
    ];
}
