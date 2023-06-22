<?php

namespace App\Models;

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
        'tgl_masuk',
        'tgl_keluar',
        'tgl_jatuh_tempo_ipl',
        'tgl_jatuh_tempo_util'
    ];

    protected $date = ['deleted_at'];

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function pemilik()
    {
        return $this->hasOne(OwnerH::class, 'id_pemilik', 'id_pemilik');
    }

}
