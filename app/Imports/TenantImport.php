<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\Tenant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
        $count = $connTenant->count();
        $count = $count + 1;

        $connTenant = ConnectionDB::setConnection(new Tenant());

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
        
        return $connTenant;
    }
   



}
