<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Jobs\ImportUnit;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Tower;
use App\Models\Floor;

class UnitImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $site =  Auth::user()->Site;

        ImportUnit::dispatch($row, $site);

        // $connUnit = ConnectionDB::setConnection(new Unit());
        // $tower = ConnectionDB::setConnection(new Tower())->first();
        // $site =  Auth::user()->id_site;

        // $count = $connUnit->count();
        // $count += 1;
        // if ($count < 10) {
        //     $count = '0' . $count;
        // };

        // $id_unit = $site . $tower->id_tower . $count;


        // $connUnit->id_unit = $id_unit;
        // $connUnit->id_site = Auth::user()->id_site;
        // $connUnit->id_tower = $this->Tower($row[0]);
        // $connUnit->id_lantai = $this->Floor($row[1]);
        // $connUnit->id_hunian = $row[2] == 'Hunian' ? 1 : 2;
        // $connUnit->nama_unit = $row[3];
        // $connUnit->luas_unit = $row[4];
        // $connUnit->no_meter_air = $row[5];
        // $connUnit->no_meter_listrik = $row[6];
        // $connUnit->meter_air_awal = $row[7];
        // $connUnit->meter_listrik_awal = $row[8];
        // $connUnit->keterangan = $row[9];
        // $connUnit->GenerateBarcode();

        // return $connUnit;
    }

    // function Tower($query)
    // {
    //     $connModel = ConnectionDB::setConnection(new Tower());

    //     $data = $connModel->where('nama_tower', 'like', '%' . $query . '%')->first();

    //     return $data ? $data->id_tower : null;
    // }

    // function Floor($query)
    // {
    //     $connModel = ConnectionDB::setConnection(new Floor);

    //     $data = $connModel->where('nama_lantai', 'like', '%' . $query . '%')->first();

    //     return $data ? $data->id_lantai : null;
    // }
}
