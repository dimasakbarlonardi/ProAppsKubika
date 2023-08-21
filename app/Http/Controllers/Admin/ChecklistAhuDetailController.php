<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAhuDetail;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistParameterEquiqment;
use App\Models\EngAhu;
use App\Models\EquiqmentAhu;
use App\Models\EquiqmentEngineeringDetail;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistAhuDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EquiqmentAhu());
        $equiqmentDetail = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $checklist = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $user_id = $request->user()->id;
        
        $data['equiqmentdetails'] = $equiqmentDetail->get();
        $data['checklistahu'] = $conn->first();
        $data['parameters'] = $checklist->get();

        $data['idusers'] = Login::where('id', $user_id)->get();
        return view('AdminSite.ChecklistAhuDetail.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.ChecklistAhuDetail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuDetail());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_ahu' => $request->id_ahu,
                'no_checklist_ahu' => $request->no_checklist_ahu,
                'in_out' => $request->in_out,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis AHU Detail');

            return redirect()->route('ahudetails.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis AHU Detail');

            return redirect()->route('ahudetails.index');
        }
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
        $conn = ConnectionDB::setConnection(new ChecklistAhuDetail());

        $data['ahusdetail'] = $conn->find($id);

        return view('AdminSite.ChecklistAhuDetail.edit', $data);
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
        $conn = ConnectionDB::setConnection(new ChecklistAhuDetail());

        $ahudetail = $conn->find($id);
        $ahudetail->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Checklis AHU Detail');

        return redirect()->route('ahudetails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)                            
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuDetail());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Checklist AHU Detail');

        return redirect()->route('ahudetails.index');
    }
}
