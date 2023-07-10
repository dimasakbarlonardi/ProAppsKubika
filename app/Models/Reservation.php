<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_request_reservation';

    protected $fillable = [
        'no_tiket',
        'no_request_reservation',
        'tgl_request_reservation',
        'id_type_reservation',
        'id_ruang_reservation',
        'id_jenis_acara',
        'keterangan',
        'durasi_acara',
        'waktu_mulai',
        'waktu_akhir',
        'jumlah_deposit',
        'no_cash_receipt',
        'status_bayar',
        'sign_approval_1',
        'sign_approval_2',
        'sign_approval_3',
        'sign_approval_4',
        'sign_approval_5',
    ];

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_tiket', 'no_tiket');
    }

    public function TypeReservation()
    {
        return $this->hasOne(TypeReservation::class, 'id_type_reservation', 'id_type_reservation');
    }

    public function RuangReservation()
    {
        return $this->hasOne(RuangReservation::class, 'id_ruang_reservation', 'id_ruang_reservation');
    }

    public function JenisAcara()
    {
        return $this->hasOne(JenisAcara::class, 'id_jenis_acara', 'id_jenis_acara');
    }

    protected $dates = ['deleted_at'];
}
