<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\EquipmentHousekeepingDetail;
use App\Models\EquiqmentEngineeringDetail;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function checklistengineering(Request $request)
    {
        $connInspectionEng = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $inspection = $connInspectionEng->get();

        return ResponseFormatter::success([
            $inspection
        ], 'Berhasil mengambil Equiqment Engineering');
    }

}
