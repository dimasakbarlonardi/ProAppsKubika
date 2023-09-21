<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\ChecklistParameterEquiqment;
use App\Models\EquipmentHousekeepingDetail;
use App\Models\EquiqmentToilet;
use App\Models\Login;
use Illuminate\Http\Request;

class ChecklistToiletDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EquiqmentToilet());
        $equiqmentDetail = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $user_id = $request->user()->id;

        $data['equiqmentdetails'] = $equiqmentDetail->where('status_schedule', '!=', 'Not done')->get();
        $data['checklisttoilet'] = $conn->first();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistToiletDetail.index',$data);
    }
}
