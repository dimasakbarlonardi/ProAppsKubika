<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    public function getAllTenants($db)
    {
        $query = DB::connection($db)
            ->table('tb_tenant')
            ->leftJoin('tb_user', 'tb_user.id_user', '=', 'tb_tenant.id_user')
            ->where('tb_tenant.deleted_at', null)
            ->get();

        return $query;
    }
    protected $primaryKey = 'id_tenant';
    public $incrementing = false;
    protected $table = 'tb_tenant';

    protected $fillable =[
        'id_tenant',
        'email_tenant',
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
        'no_telp_penjamin',

    ];

    protected $dates = ['deleted_at'];

    public function StatusHunian()
    {
        return $this->hasOne(StatusHunianTenant::class, 'id_statushunian_tenant', 'id_statushunian_tenant');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'login_user', 'email_tenant');
    }

    public function IdCard()
    {
        return $this->hasOne(IdCard::class, 'id_card_type', 'id_card_type');
    }

    public function sites()
    {
        return $this->hasOne(Site::class, 'id_site', 'id_site');
    }

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }

    public function TenantUnit()
    {
        return $this->hasMany(TenantUnit::class, 'id_tenant', 'id_tenant');
    }

    public function Tenant()
    {
        return $this->hasMany(OpenTicket::class, 'id_user', 'id_user');
    }
}
