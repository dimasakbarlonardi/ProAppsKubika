<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\Login;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TenantImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connTenant =  ConnectionDB::setConnection(new Tenant());
        $connUser =  ConnectionDB::setConnection(new User());

        $count = $connTenant->count();
        $count = $count + 1;

        $connTenant->id_site = Auth::user()->id_site;
        $connTenant->id_tenant = sprintf("%03d", $count);
        $connTenant->nama_tenant = $row[0];
        $connTenant->email_tenant = $row[1];
        $connTenant->nik_tenant = $row[2];
        $connTenant->id_card_type = $row[3] == 'KTP' ? 1 : 2;
        $connTenant->id_statushunian_tenant = $row[4] == 'Hunian' ? 1 : 2;
        $connTenant->kewarganegaraan = $row[5];
        $connTenant->provinsi = $row[6];
        $connTenant->alamat_ktp_tenant = $row[7];
        $connTenant->kode_pos = $row[8];
        $connTenant->no_telp_tenant = $row[9];
        $connTenant->id_status_kawin = $row[10] == 'Menikah' ? 1 : 2;
        $connTenant->nama_pasangan_penjamin = $row[11];
        $connTenant->nik_pasangan_penjamin = $row[12];
        $connTenant->alamat_ktp_pasangan_penjamin = $row[13];
        $connTenant->alamat_tinggal_pasangan_penjamin = $row[14];
        $connTenant->hubungan_penjamin = $row[15];
        $connTenant->no_telp_penjamin = $row[16];
        $connTenant->profile_picture = '/storage/img/proapps.png';

        $createLogin = Login::create([
            'name' => $row[0],
            'email' => $row[1],
            'password' => Hash::make('password'),
            'id_site' => Auth::user()->id_site
        ]);

        $connUser->create([
            'id_site' => Auth::user()->id_site,
            'id_user' => strval(Carbon::now()->format('Y') . sprintf("%03d", $count + 1)),
            'nama_user' => $row[0],
            'login_user' => $row[1],
            'password_user' => Hash::make('password'),
            'id_status_user' => 1,
            'id_role_hdr' => 3,
            'user_category' => 3,
            'profile_picture' => $connTenant->profile_picture,
        ]);

        $connTenant->update([
            'id_user' => $createLogin->id
        ]);

        return $connTenant;
    }
}
