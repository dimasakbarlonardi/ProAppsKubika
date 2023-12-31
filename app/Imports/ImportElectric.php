<?php

namespace App\Imports;

use App\Helpers\ConnectionDB;
use App\Helpers\InvoiceHelper;
use App\Models\ElectricUUS;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportElectric implements ToModel, WithStartRow
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
            $connElectric = ConnectionDB::setConnection(new ElectricUUS());

            $usage = $row[2] - $row[1];
            $get_abodemen = InvoiceHelper::getAbodemen($this->Unit($row[0]), $usage);

            $electricUUS = $connElectric->create([
                'periode_bulan' => $this->data->periode_bulan,
                'periode_tahun' => $this->data->periode_tahun,
                'id_unit' => $this->Unit($row[0]),
                'nomor_listrik_awal' => $row[1],
                'nomor_listrik_akhir' => $row[2],
                'usage' => $usage,
                'abodemen_value' => $get_abodemen['abodemen'],
                'is_abodemen' => $get_abodemen['isAbodemen'],
                'ppj' => $get_abodemen['ppj'],
                'total' => $get_abodemen['total'],
                'id_user' => $this->data->session()->get('user_id')
            ]);

            return $electricUUS;
        }
    }

    function Unit($query)
    {
        $connModel = ConnectionDB::setConnection(new Unit());

        $data = $connModel->where('nama_unit', 'like', '%' . $query . '%')->first();

        return $data ? $data->id_unit : null;
    }
}
