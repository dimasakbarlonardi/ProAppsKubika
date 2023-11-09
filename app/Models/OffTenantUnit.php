<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffTenantUnit extends Model
{
    use HasFactory;

    protected $table = 'tb_tenant_off';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_tenant',
        'id_site',
        'id_unit',
        'tgl_sys',
        'tgl_masuk',
        'tgl_keluar',
        'keterangan',
    ];

    protected $dates = ['deleted_at'];
}
