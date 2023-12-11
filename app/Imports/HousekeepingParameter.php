<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\Toilet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class HousekeepingParameter implements ToModel, WithStartRow
{
   
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connHK = ConnectionDB::setConnection(new Toilet());

        $connHK->nama_hk_toilet = $row[1];

        return $connHK;
    }
}
