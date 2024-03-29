<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KendaraanTenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_tenant_vehicle';
    protected $primaryKey = 'id_tenant_vehicle';

    protected $fillable = [
        'id_tenant_vehicle',
        'id_tenant',
        'id_unit',
        'id_jenis_kendaraan',
        'no_polisi',
        'keterangan'
    ];

    protected $dates = ['deleted_at'];

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class, 'id_tenant','id_tenant' );
    }

    public function jeniskendaraan()
    {
        return $this->hasOne(JenisKendaraan::class, 'id_jenis_kendaraan', 'id_jenis_kendaraan');
    }
}
