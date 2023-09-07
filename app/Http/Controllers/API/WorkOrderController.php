<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function show($id)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->where('id', $id)
        ->with(['Ticket', 'WODetail'])
        ->first();

        return ResponseFormatter::success(
            $wo,
            'Success get WO'
        );
    }

    public function acceptWO($id)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->find($id);

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_1 = '1';
        $wo->date_approve_1 = Carbon::now();
        $wo->save();

        return ResponseFormatter::success(
            $wo,
            'Success approve WO'
        );
    }
}
