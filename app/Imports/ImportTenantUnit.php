<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\Tenant;
use App\Models\TenantUnit;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportTenantUnit implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    function generateTenantUnitID($tu)
    {
        $tu = $tu->count();
        $tu++;
        $tu_id = str_pad($tu, 9, '0', STR_PAD_LEFT);

        return $tu_id;
    }

    public function model(array $row)
    {
        if ($this->Tenant($row[1]) && $this->Unit($row[0])) {

            $owner = ConnectionDB::setConnection(new TenantUnit());
            $id_tenant_unit = $this->generateTenantUnitID($owner);
            $owner->id_tenant_unit = $id_tenant_unit;
            $owner->id_unit = $this->Unit($row[0]);
            $owner->id_tenant = $this->Tenant($row[1]);
            $owner->tgl_masuk = $row[4];
            $owner->tgl_keluar = $row[5];
            $owner->is_owner = 1;
            $owner->sewa_ke = 1;
            $owner->save();

            if ($this->Tenant($row[3]) && $row[3]) {
                $renter = ConnectionDB::setConnection(new TenantUnit());
                $id_tenant_unit = $this->generateTenantUnitID($renter);
                $renter->id_tenant_unit = $id_tenant_unit;
                $renter->id_unit = $this->Unit($row[0]);
                $renter->id_tenant = $this->Tenant($row[3]);
                $renter->tgl_masuk = $row[4];
                $renter->tgl_keluar = $row[5];
                $renter->is_owner = 0;
                $renter->sewa_ke = 1;
                $renter->save();
            }
        }
    }

    function Unit($query)
    {
        $connModel = ConnectionDB::setConnection(new Unit());

        $data = $connModel->where('nama_unit', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_unit : null;
    }

    function Tenant($query)
    {
        $connModel = ConnectionDB::setConnection(new Tenant());

        $data = $connModel->where('email_tenant', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_tenant : null;
    }
}
