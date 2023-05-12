<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes ;

    protected $primaryKey = 'id_tenant';
    public $incrementing = false;
    protected $table = 'tb_tenant';

    protected $fillable =[
        'id_tenant',
        'id_site',
        'id_user',
        'id_pemilik',
        'id_card_type',
        'nik_tenant',
        'nama_tenant',
        'id_statushunian_tenant',
        'kewarganegaraan',
        'masa_berlaku_id',
        'alamat_ktp_tenant',
        'provinsi',
        'kode_pos',
        'alamat_tinggal_tenant',
        'no_telp_tenant',
        'nik_pasangan_penjamin',
        'nama_pasangan_penjamin',
        'alamat_ktp_pasangan_penjamin',
        'alamat_tinggal_pasangan_penjamin',
        'hubungan_penjamin',
        'no_telp_penjamin'

    ];

    protected $dates = ['deleted_at'];

    public function StatusHunianTenant()
    {
        return $this->hasOne(StatusHunianTenant::class, 'id_statushunian_tenant', 'id_statushunian_tenant');
    }

}
