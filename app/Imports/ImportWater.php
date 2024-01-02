<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Helpers\InvoiceHelper;
use App\Models\Unit;
use App\Models\WaterUUS;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportWater implements ToModel, WithStartRow
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function startRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        if ($this->Unit($row[0])) {
            $connWater = ConnectionDB::setConnection(new WaterUUS());

            $usage = $row[2] - $row[1];
            $inputWater = InvoiceHelper::InputWaterUsage($this->Unit($row[0]), $usage);

            $isExist = $connWater->where('periode_bulan', $this->data->periode_bulan)
            ->where('periode_tahun', $this->data->periode_tahun)
            ->where('id_unit', $this->Unit($row[0]))
            ->first();

            if (!$isExist) {
                $waterUUS = $connWater->create([
                    'periode_bulan' => $this->data->periode_bulan,
                    'periode_tahun' => $this->data->periode_tahun,
                    'id_unit' => $this->Unit($row[0]),
                    'nomor_air_awal' => $row[1],
                    'nomor_air_akhir' => $row[2],
                    'usage' => $usage,
                    'total' => $inputWater['total'],
                    'id_user' => $this->data->session()->get('user_id')
                ]);

                return $waterUUS;
            }
        }
    }

    function Unit($query)
    {
        $connModel = ConnectionDB::setConnection(new Unit());

        $data = $connModel->where('nama_unit', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_unit : null;
    }
}
