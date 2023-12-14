<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\Floor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FloorImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connFloor = ConnectionDB::setConnection(new Floor());

        $connFloor->id_lantai = rand(100, 200);
        $connFloor->nama_lantai = $row[1];

        return $connFloor;
    }
}
