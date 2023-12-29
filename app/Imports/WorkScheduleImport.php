<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\Karyawan;
use App\Models\WorkTimeline;
use App\Models\ShiftType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class WorkScheduleImport implements ToModel, WithStartRow
{
    private $karyawan_id;

    public function __construct ($karyawan_id)
    {
        $this->karyawan_id = $karyawan_id;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connWorkTimeline = ConnectionDB::setConnection(new WorkTimeline());
      
        $connWorkTimeline->karyawan_id = $this->karyawan_id;
        $connWorkTimeline->shift_type_id = $this->ShiftType($row[1]);
        $connWorkTimeline->date = $row[2];

        return $connWorkTimeline;
    } 

    function ShiftType($query)
    {
        $connModel = ConnectionDB::setConnection(new ShiftType());

        $data = $connModel->where('shift', 'like', '%' . $query . '%')->first();

        return $data ? $data->id : null;
    }
}

