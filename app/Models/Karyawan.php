<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_karyawan';

    protected $fillable = [
        'id_user',
        'email_karyawan',
        'id_karyawan',
        'id_site',
        'id_card_type',
        'nik_karyawan',
        'nama_karyawan',
        'id_status_karyawan',
        'id_status_kawin_karyawan',
        'id_status_aktif_karyawan',
        'kewarganegaraan',
        'masa_berlaku_id',
        'alamat_ktp_karyawan',
        'no_telp_karyawan',
        'nik_pasangan_penjamin',
        'nama_pasangan_penjamin',
        'alamat_ktp_pasangan_penjamin',
        'alamat_tinggal_pasangan_penjamin',
        'hubungan_penjamin',
        'no_telp_penjamin',
        'tgl_masuk',
        'tgl_keluar',
        'id_jabatan',
        'id_divisi',
        'id_departemen',
        'id_penempatan',
        'tempat_lahir',
        'tgl_lahir',
        'id_agama',
        'id_jenis_kelamin',
        'is_can_approve'
    ];

    protected $date = ['deleted_at'];

    public function User()
    {
        return $this->hasOne(User::class, 'login_user', 'email_karyawan');
    }

    public function IdCard()
    {
        return $this->hasOne(IdCard::class, 'id_card_type', 'id_card_type' );
    }

    public function site()
    {
        return $this->hasOne(Site::class, 'id_site', 'id_site' );
    }

    public function Agama()
    {
        return $this->hasOne(Agama::class, 'id_agama', 'id_agama' );
    }

    public function JenisKelamin()
    {
        return $this->hasOne(JenisKelamin::class, 'id_jenis_kelamin', 'id_jenis_kelamin' );
    }

    public function Jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id_jabatan', 'id_jabatan' );
    }

    public function Divisi()
    {
        return $this->hasOne(Divisi::class, 'id_divisi', 'id_divisi' );
    }

    public function Departemen()
    {
        return $this->hasOne(Departemen::class, 'id_departemen', 'id_departemen' );
    }

    public function Penempatan()
    {
        return $this->hasOne(Penempatan::class, 'id_penempatan', 'id_penempatan' );
    }

    public function StatusKaryawan()
    {
        return $this->hasOne(StatusKaryawan::class, 'id_status_karyawan', 'id_status_karyawan' );
    }

    public function StatusAktifKaryawan()
    {
        return $this->hasOne(StatusAktifKaryawan::class, 'id_status_aktif_karyawan', 'id_status_aktif_karyawan' );
    }

    public function StatusKawinKaryawan()
    {
        return $this->hasOne(StatusKawin::class, 'id_status_kawin', 'id_status_kawin_karyawan' );
    }

}
