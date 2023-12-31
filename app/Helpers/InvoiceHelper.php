<?php

namespace App\Helpers;

use App\Models\System;
use App\Models\Unit;
use App\Models\Utility;
use Illuminate\Support\Carbon;

class InvoiceHelper
{
    public static function generateInvoiceNumber()
    {
        $connSystem = ConnectionDB::setConnection(new System());

        $data['system'] = $connSystem->find(1);

        $data['countINV'] = $data['system']->sequence_no_invoice + 1;
        $data['no_inv'] = $data['system']->kode_unik_perusahaan . '/' .
            $data['system']->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $data['countINV']);

        // $system->sequence_no_invoice = $countINV;
        // $system->save();

        return $data;
    }

    public static function getAbodemen($unitID, $usage)
    {
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connUtility = ConnectionDB::setConnection(new Utility());

        $unit = $connUnit->find($unitID);

        if ($unit->id_hunian == 1) {
            $listrik = $connUtility->find(1);
        } elseif ($unit->id_hunian == 2) {
            $listrik = $connUtility->find(5);
        }

        $isAbodemen = false;
        $biaya_usage = $listrik->biaya_m3;
        $get_ppj = $listrik->biaya_ppj / 100;
        $electric_capacity = $unit->electric_capacity;
        $abodemen = (40 * $electric_capacity) / 1000;

        if ($usage < $abodemen) {
            $isAbodemen = true;
        }

        if ($isAbodemen) {
            if ($listrik->biaya_tetap != 0) {
                $total_usage = $listrik->biaya_tetap;
            } else {
                $total_usage = $biaya_usage * $usage;
            }
        } else {
            $total_usage = $biaya_usage * $usage;
        }

        $ppj = $get_ppj * $total_usage;
        $total = $total_usage + $ppj;

        $data = [
            'isAbodemen' => $isAbodemen,
            'total_usage' => $total_usage,
            'get_ppj' => $get_ppj,
            'abodemen' => $abodemen,
            'ppj' => $ppj,
            'total' => $total
        ];

        return $data;
    }

    public static function InputWaterUsage($unitID, $usage)
    {
        $connUtility = ConnectionDB::setConnection(new Utility());
        $connUnit = ConnectionDB::setConnection(new Unit());

        $unit = $connUnit->find($unitID);

        if ($unit->id_hunian == 1) {
            $water = $connUtility->find(2);
        } elseif ($unit->id_hunian == 2) {
            $water = $connUtility->find(6);
        }

        $total_usage = $water->biaya_m3 * $usage;
        $total = $total_usage;

        $data = [
            'total_usage' => $total_usage,
            'total' => $total
        ];

        return $data;
    }
}
