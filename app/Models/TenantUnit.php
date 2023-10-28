<?php

namespace App\Models;

use App\Helpers\ConnectionDB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_tenant_unit';
    protected $primaryKey = 'id_tenant_unit';
    public $incrementing = false;

    protected $fillable = [
        'id_tenant_unit',
        'id_tenant',
        'id_unit',
        'id_pemilik',
        'id_periode_sewa',
        'sewa_ke',
        'tgl_masuk',
        'tgl_keluar',
        'tgl_jatuh_tempo_ipl',
        'tgl_jatuh_tempo_util',
        'is_owner'
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function Owner($unitID)
    {
        $connTU = ConnectionDB::setConnection(new TenantUnit());

        $tu = $connTU->where('id_unit', $unitID)
        ->where('is_owner', 1)
        ->with('Tenant')
        ->first();

        return $tu->Tenant;
    }

    public function Penyewa($unitID)
    {
        $connTU = ConnectionDB::setConnection(new TenantUnit());

        $tu = $connTU->where('id_unit', $unitID)
        ->where('is_owner', 0)
        ->with('Tenant')
        ->first();

        return $tu->Tenant;
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class, 'id_tenant', 'id_tenant');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id_user', 'id_tenant');
    }

    protected $date = ['deleted_at'];
}
