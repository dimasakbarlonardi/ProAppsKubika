<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenTicket extends Model
{
    use HasFactory;

    protected $table = 'tb_request';

    protected $fillable = [
        'id_site',
        'id_tower',
        'id_unit',
        'id_lantai',
        'id_tenant',
        'no_tiket',
        'status_request',
        'id_jenis_request',
        'judul_request',
        'deskripsi_request',
        'upload_image',
        'no_hp',
        'status_respon',
        'tgl_respon_tiket',
        'jam_respon',
        'deskripsi_respon',
        'id_user_resp_request'
    ];

    public function jenisRequest()
    {
        return $this->hasOne(JenisRequest::class, 'id_jenis_request', 'id_jenis_request');
    }

    public function Tenant()
    {
        return $this->hasOne(Tenant::class, 'id_tenant', 'id_tenant');
    }

    public function TenantRelation()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_resp_request');
    }

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }
}
