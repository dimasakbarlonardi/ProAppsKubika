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
    }
}
