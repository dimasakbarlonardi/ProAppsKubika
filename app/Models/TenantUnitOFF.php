<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantUnitOFF extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_tenant_unit_off';

    protected $fillable = [
        'id_tenant',
        'id_unit',
        'id_pemilik',
        'id_periode_sewa',
        'tgl_masuk',
        'tgl_keluar',
        'tgl_sys',
        'keterangan',
        'sewa_ke'
    ];

    protected $date = ['deleted_at'];
    
    public function Tenant(){
        return $this->hasOne(Tenant::class, 'id_tenant','id_tenant');
    }

    public function Unit(){
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }
}
