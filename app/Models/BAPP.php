<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BAPP extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_bapp';

    protected $fillable = [
        'no_tiket',
        'no_request_permit',
        'no_work_permit',
        'no_bapp',
        'tgl_penyelesaian',
        'jumlah_deposit',
        'jumlah_potongan',
        'jumlah_kembali_deposit',
        'cara_bayar',
        'bank_pemohon',
        'cabang_bank_pemohon',
        'nama_rek_pemohon',
        'rek_pemohon',
        'sign_approval_1',
        'sign_approval_2',
        'sign_approval_3',
        'sign_approval_4',
        'sign_approval_5',
        'no_cash_receipt',
        'no_cash_payment',
        'status_bayar',
        'status_pengembalian',
    ];

    public function RequestPermit()
    {
        return $this->hasOne(RequestPermit::class, 'no_request_permit', 'no_request_permit');
    }

    public function WorkPermit()
    {
        return $this->hasOne(WorkPermit::class, 'no_work_permit', 'no_work_permit');
    }

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_tiket', 'no_tiket');
    }

    protected $dates = ['deleted_at'];
}
