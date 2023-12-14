<?php

namespace App\Helpers;

use App\Models\System;
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
}
