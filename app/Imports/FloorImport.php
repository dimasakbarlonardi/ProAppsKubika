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
        
        $id_lantai = $this->generateUniqueFloorId();
        $connFloor->id_lantai = $id_lantai;
        $connFloor->nama_lantai = $row[1];

        return $connFloor;
    }

    private function generateUniqueFloorId()
    {
        $connFloor = ConnectionDB::setConnection(new Floor());
        $id_lantai = rand(200, 300);

        while ( $connFloor->where('id_lantai', $id_lantai)->exists()) {
            $id_lantai = rand(200, 300);
        }

        return $id_lantai;
    }
}
