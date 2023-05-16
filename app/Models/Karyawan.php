<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_karyawan';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;

    protected $fillable = [
        'id_karyawan ',
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
        'id_status_kawi ',
    ];

    protected $date = ['deleted_at'];

    public function IdCard()
    {
        return $this->hasOne(IdCard::class, 'id_card_type', 'id_card_type' );
    }

}
