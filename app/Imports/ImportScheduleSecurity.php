<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\ChecklistSecurity;
use App\Models\ParameterShiftSecurity;
use App\Models\Room;
use App\Models\ScheduleSecurity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ImportScheduleSecurity implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connSchedule = ConnectionDB::setConnection(new ScheduleSecurity());

        $connSchedule->id_equiqment = 3;
        $connSchedule->id_room =  $this->Room($row[1]);
        $connSchedule->schedule = $row[2];
        $connSchedule->id_shift =  $this->Shift($row[3]);

        return $connSchedule;
    }

    function Room($query)
    {
        $connModel = ConnectionDB::setConnection(new Room());

        $data = $connModel->where('nama_room', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_room : null;
    }

    function Shift($query)
    {
        $connModel = ConnectionDB::setConnection(new ParameterShiftSecurity());

        $data = $connModel->where('shift', 'like', '%' . $query . '%')->first();

        return $data ? $data->id : null;
    }
}