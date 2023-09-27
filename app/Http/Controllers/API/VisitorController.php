<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function store(Request $request)
    {
        $connVisitor = ConnectionDB::setConnection(new Visitor());

        $connVisitor->name_visitor = $request->name_visitor;
        $connVisitor->unit_id = $request->unit_id;
        $connVisitor->arrival_date = $request->arrival_date;
        $connVisitor->arrival_time = $request->arrival_time;
        $connVisitor->heading_to = $request->heading_to;
        $connVisitor->desc = $request->desc;
        $connVisitor->leave_date = $request->leave_date;
        $connVisitor->leave_time = $request->leave_time;

        $connVisitor->save();

        return ResponseFormatter::success(
            $connVisitor,
            'Success create appointment'
        );
    }

    public function visitorByUnit($id)
    {
        $connVisitor = ConnectionDB::setConnection(new Visitor());

        $visitors = $connVisitor->where('unit_id', $id)
        ->with('Unit')
        ->get();

        return ResponseFormatter::success(
            $visitors,
            'Success get visitors by unit'
        );
    }

    public function show($id)
    {
        $connVisitor = ConnectionDB::setConnection(new Visitor());

        $visitor = $connVisitor->find($id);

        return ResponseFormatter::success(
            $visitor,
            'Success visitors detail'
        );
    }

    // public function arrive($id)
    // {
    //     $connVisitor = ConnectionDB::setConnection(new Visitor());

    //     $visitor = $connVisitor->find($id);
    //     $visitor->status = 'Arrive';
    //     $visitor->save();

    //     return ResponseFormatter::success(
    //         $visitor,
    //         'Success visitors detail'
    //     );
    // }
}
