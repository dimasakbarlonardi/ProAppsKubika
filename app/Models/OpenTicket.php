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
        'id_tenant',
        'id_tower',
        'id_unit',
        'id_lantai',
        'no_tiket',
        'no_invoice',
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
        'id_user_resp_request',
        'sign_approve_1',
        'date_approve_1',
        'sign_approve_2',
        'date_approve_2',
        'priority'
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

    public function User()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_resp_request');
    }

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function WorkRequest()
    {
        return $this->hasOne(WorkRequest::class, 'no_tiket', 'no_tiket');
    }

    public function WorkOrder()
    {
        return $this->hasOne(WorkOrder::class, 'no_tiket', 'no_tiket');
    }

    public function RequestGIGO()
    {
        return $this->hasOne(RequestGIGO::class, 'no_tiket', 'no_tiket');
    }

    public function CashReceipt()
    {
        return $this->hasOne(CashReceipt::class, 'no_invoice', 'no_invoice');
    }

    public function Tower()
    {
        return $this->hasOne(Tower::class, 'id_tower', 'id_tower');
    }

    public function ResponseBy()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_resp_request');
    }

    public function RequestReservation()
    {
        return $this->hasOne(Reservation::class, 'no_tiket', 'no_tiket');
    }

    public function TenantUnit()
    {
        return $this->hasMany(TenantUnit::class, 'id_unit', 'id_unit');
    }
}
