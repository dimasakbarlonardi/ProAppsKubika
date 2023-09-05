<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Carbon\Carbon;
use App\Models\InspectionSecurity;

class SecurityImport implements ToModel, WithCustomCsvSettings
{
    public function model(array $row)
    {
        $tgl_patrol = Carbon::createFromFormat('d/m/Y H:i:s', $row[2])->format('Y-m-d');
        return new InspectionSecurity([
            'id_guard' => $row[0],
            'checkpoint_name' => $row[1],
            'tgl_patrol' => $tgl_patrol,
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => '/t', // Ganti dengan pemisah yang sesuai
        ];
    }
}
