<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\InspectionSecurity;
use App\Imports\SecurityImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $security = ConnectionDB::setConnection(new InspectionSecurity());

        try {
            $file = $request->file('excel_file');

            $importedData = Excel::toCollection(new SecurityImport(), $file);

            $dataRows = $importedData[0]->slice(1); 


            foreach ($dataRows as $row) {
                dd($row);
                $security->create([
                    'id_guard' => $row[0],
                    'checkpoint_name' => $row[1],
                    'tgl_patrol' => $row[2],
                ]);
            }

            Alert::success('Berhasil', 'Berhasil menambahkan Inspection Security');

            return redirect()->route('inspectionsecurity.index');
        } catch (\Throwable $e) {
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Inspection Security');

            return redirect()->route('inspectionsecurity.index');
        }
    }
}
