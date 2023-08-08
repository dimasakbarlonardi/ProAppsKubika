<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function insertElectricMeter(Request $request, $id)
    {
        $connUnit = ConnectionDB::setConnection(new Unit());

        $data['unit'] = $connUnit->find('0042120104');

        return view('AdminSite.UtilityUsageRecording.Electric.create', $data);
    }
}
