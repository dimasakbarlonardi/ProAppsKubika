<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\EquiqmentToilet;
use App\Models\Room;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EquipmentHousekeeping implements ToModel, WithStartRow

{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connEquipment = ConnectionDB::setConnection(new EquiqmentToilet());

        $connEquipment->id_equiqment = 1;
        $connEquipment->no_equipment = $row[1];
        $connEquipment->id_room =  $this->Room($row[2]);


        return $connEquipment;
    }

    function Room($query)
    {
        $connModel = ConnectionDB::setConnection(new Room());

        $data = $connModel->where('nama_room', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_room : null;
    }
}
