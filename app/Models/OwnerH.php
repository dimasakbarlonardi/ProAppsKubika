<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OwnerH extends Model
{
    use HasFactory, SoftDeletes ;

    public function getAllOwners($db)
    {
        $query = DB::connection($db)
            ->table('tb_pemilik_h')
            ->leftJoin('tb_user', 'tb_user.id_user', '=', 'tb_pemilik_h.id_pemilik')
            ->get();

        return $query;
    }
    
    protected $table = 'tb_pemilik_h';
    protected $primaryKey = 'id_pemilik';
    public $incrementing = false;

    protected $fillable =[
        'id_pemilik',
        'id_site',
        'id_user',
        'id_card_type',
        'nik_pemilik',
        'nama_pemilik',
        'id_status_aktif_pemilik',
        'kewarganegaraan',
        'masa_berlaku_id',
        'alamat_ktp_pemilik',
        'alamat_tinggal_pemilik',
        'provinsi',
        'kode_pos',
        'no_telp_pemilik',
        'nik_pasangan_penjamin',
        'nama_pasangan_penjamin',
        'alamat_ktp_pasangan_penjamin',
        'alamat_tinggal_pasangan_penjamin',
        'hubungan_penjamin',
        'no_telp_penjamin',
        'tgl_masuk',
        'tgl_keluar',
        'id_kempemilikan_unit',
        'tempat_lahir',
        'tgl_lahir',
        'id_jenis_kelamin',
        'id_agama',
        'id_status_kawin',
        'pekerjaan',
        'nik_kontak_pic',
        'nama_kontak_pic',
        'alamat_tinggal_kontak_pic',
        'email_kontak_pic',
        'no_telp_kontak_pic',
        'hubungan_kontak_pic'

    ];

    protected $dates = ['deleted_at'];
    
    public function Login()
    {
        return $this->hasOne(Login::class, 'id', 'id');
    }

    public function IdCard()
    {
        return $this->hasOne(IdCard::class, 'id_card_type', 'id_card_type');
    }

    public function jeniskelamin()
    {
        return $this->hasOne(JenisKelamin::class, 'id_jenis_kelamin', 'id_jenis_kelamin');
    }

    public function statuskawin()
    {
        return $this->hasOne(StatusKawin::class, 'id_status_kawin', 'id_status_kawin');
    }

    public function agama()
    {
        return $this->hasOne(Agama::class, 'id_agama', 'id_agama');
    }

    public function iduser()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }
}
