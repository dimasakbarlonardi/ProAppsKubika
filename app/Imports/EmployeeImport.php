<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\Agama;
use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EmployeeImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $connKaryawan->email_karyawan = $row[1];
        $connKaryawan->id_karyawan = sprintf("%04d", $connKaryawan->id);
        $connKaryawan->id_site = Auth::user()->id_site;
        $connKaryawan->id_card_type = $row[2] == 'KTP' ? 1 : 2;
        $connKaryawan->nik_karyawan = $row[3];
        $connKaryawan->nama_karyawan = $row[0];
        $connKaryawan->kewarganegaraan = $row[4];
        $connKaryawan->alamat_ktp_karyawan = $row[5];
        $connKaryawan->no_telp_karyawan = $row[6];
        $connKaryawan->tgl_masuk = $row[7];
        $connKaryawan->tgl_keluar = $row[8];
        $connKaryawan->id_jenis_kelamin = $row[9] == 'L' ? 1 : 2;
        $connKaryawan->is_can_approve = $row[10] == 1 ? 1 : null;
        $connKaryawan->profile_picture = '/storage/img/proapps.png';
        $connKaryawan->id_jabatan = $this->Jabatan($row[11]);
        $connKaryawan->id_divisi = $this->Divisi($row[12]);
        $connKaryawan->id_departemen = $this->Department($row[13]);
        $connKaryawan->tempat_lahir = $row[14];
        $connKaryawan->tgl_lahir = $row[15];
        $connKaryawan->id_agama = $this->Religion($row[16]);

        return $connKaryawan;
    }

    function Jabatan($query)
    {
        $connModel = ConnectionDB::setConnection(new Jabatan());

        $data = $connModel->where('nama_jabatan', 'like', '%' . $query . '%')->first();

        return $data->id_jabatan;
    }

    function Divisi($query)
    {
        $connModel = ConnectionDB::setConnection(new Divisi());

        $data = $connModel->where('nama_divisi', 'like', '%' . $query . '%')->first();

        return $data->id_divisi;
    }

    function Department($query)
    {
        $connModel = ConnectionDB::setConnection(new Departemen());

        $data = $connModel->where('nama_departemen', 'like', '%' . $query . '%')->first();

        return $data->id_departemen;
    }

    function Religion($query)
    {
        $connModel = ConnectionDB::setConnection(new Agama());

        $data = $connModel->where('nama_agama', 'like', '%' . $query . '%')->first();

        return $data->id_agama;
    }
}
