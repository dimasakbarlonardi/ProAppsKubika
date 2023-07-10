<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistOfficeManagementDetail;
use App\Models\ChecklistOfficeManagementH;
use App\Models\Login;
use App\Models\OfficeManagement;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistOfficeManagementHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistOfficeManagementH());
        $user_id = $request->user()->id;
        
        $data ['checklistoffices'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistOfficeH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistOfficeManagementH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_office_management) {
            $data = $data->where('no_checklist_office_management', $request->no_checklist_office_management);
        }
        $data = $data->get();
        return response()->json(['checklists' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $connroom = ConnectionDB::setConnection(new Room());
        $connoffice = ConnectionDB::setConnection(new OfficeManagement());
        
        $data ['rooms'] = $connroom->get();
        $data ['engoffices'] = $connoffice->get();

        return view('AdminSite.ChecklistOfficeH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistOfficeManagementH());
        $conndetail = ConnectionDB::setConnection(new ChecklistOfficeManagementDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $office = ConnectionDB::setConnection(new OfficeManagement());

            $id_office = $office->first('id_hk_office');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_office = $id_office->id_hk_office . $today . $current;
            
            $conn->create([
                'id_eng_checklist_office_management' => $request->id_eng_checklist_office_management,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_office_management' => $no_checklist_office,
                'periode' => $request->periode
            ]);

            $conndetail->create([
                'id_eng_office_management' => $request->count,
                'no_checklist_office_management' => $no_checklist_office,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis office');

            return redirect()->route('checklistoffices.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis office');

            return redirect()->route('checklistoffices.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistOfficeManagementH());
        $conndetail = ConnectionDB::setConnection(new ChecklistOfficeManagementDetail());
        $user_id = $request->user()->id;

        $data['checklistoffice'] = $conn->where('no_checklist_office_management', $id)->first();
        $data['officedetail'] = $conndetail->where('no_checklist_office_management', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistOfficeH.show',$data);
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
