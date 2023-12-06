<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Models\ParameterSecurity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class SecurityParameter implements ToModel, WithStartRow
{
   
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $connSEC = ConnectionDB::setConnection(new ParameterSecurity());

        $connSEC->name_parameter_security = $row[1];

        return $connSEC;
    }
}

