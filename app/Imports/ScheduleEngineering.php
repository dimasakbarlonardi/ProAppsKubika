<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\EquiqmentEngineeringDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ScheduleEngineering implements ToModel, WithStartRow
{
    private $id_equiqment_engineering;

    public function __construct(int $id_equiqment_engineering)
    {
        $this->id_equiqment_engineering = $id_equiqment_engineering;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connSchedule = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $connSchedule->id_equiqment_engineering = $this->id_equiqment_engineering;
        $connSchedule->schedule = $row[1];
        $connSchedule->status_schedule =  'Not Done';

        return $connSchedule;
    }
}
