<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
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
            'Berhasil mengambil semua tickets'
        );
    }
}
