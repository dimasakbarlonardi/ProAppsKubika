<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TenantImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    
}
