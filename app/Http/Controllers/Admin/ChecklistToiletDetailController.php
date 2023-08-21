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

        $checklist = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        // // $user_id = $request->user()->id;
        
        $data['equiqmentdetails'] = $equiqmentDetail->get();
        $data['checklisttoilet'] = $conn->first();
        $data['parameters'] = $checklist->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistToiletDetail.index',$data);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
