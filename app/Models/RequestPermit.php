<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestPermit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_request_permit';
    protected $fillable = [
        'id_site',
        'no_tiket',
        'id_jenis_pekerjaan',
        'keterangan_pekerjaan',
        'status_request',
        'id_tenant',
        'no_request_permit',
        'approval_1',
        'approval_2',
        'approval_3',
        'nama_kontraktor',
        'pic',
        'alamat',
        'no_ktp',
        'no_telp',
        'tgl_mulai',
        'tgl_akhir',
    ];

    public function Tenant()
    {
        return $this->hasOne(Tenant::class, 'id_tenant',  'id_tenant');
    }

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_tiket', 'no_tiket');
    }

    public function JenisPekerjaan()
    {
        return $this->hasOne(JenisPekerjaan::class, 'id_jenis_pekerjaan', 'id_jenis_pekerjaan');
    }

    public function RPDetail()
    {
        return $this->hasOne(RequestPermitDetail::class, 'no_tiket', 'no_tiket');
    }

    protected $dates = ['deleted_at'];
}
