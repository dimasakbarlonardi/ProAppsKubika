<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\EngAhu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EngineeringParameter implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connEng = ConnectionDB::setConnection(new EngAhu());

        $connEng->nama_eng_ahu = $row[1];

        return $connEng;
    }
}
