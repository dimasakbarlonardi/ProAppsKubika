<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\EquipmentHousekeepingDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ScheduleHousekeeping implements ToModel, WithStartRow
{
    private $id_equipment_housekeeping;

    public function __construct (int $id_equipment_housekeeping)
    {
        $this->id_equipment_housekeeping = $id_equipment_housekeeping;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connSchedule = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $connSchedule->id_equipment_housekeeping = $this->id_equipment_housekeeping;
        $connSchedule->schedule = $row[1];
        $connSchedule->status_schedule =  'Not Done';

        return $connSchedule;
    }
}
