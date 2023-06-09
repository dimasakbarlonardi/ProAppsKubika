<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberTenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_tenant_member';
    protected $primaryKey = 'id_tenant_member';

    protected $fillable = [
        'id_tenant_member',
        'id_unit',
        'id_tenant',
        'nik_tenant_member',
        'nama_tenant_member',
        'hubungan_tenant',
        'no_telp_member',
        'id_status_tinggal',
    ];
    protected $dates = ['deleted_at'];

    public function status()
    {
        return $this->hasOne(StatusTinggal::class, 'id_status_tinggal','id_status_tinggal' );
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class, 'id_tenant','id_tenant' );
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }
}
