<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistPemadamH;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistPemadamDetail;
use App\Models\EngPemadam;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistPemadamHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPemadamH());
        $user_id = $request->user()->id;
        
        $data ['checklistpemadams'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistPemadamH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPemadamH());

        $data = $conn->where('no_checklist_pemadam', $request->no_checklist_pemadam)
        ->whereBetween('tgl_checklist', [$request->date_from, $request->date_to])
        ->get();

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
        $connpemadam = ConnectionDB::setConnection(new EngPemadam());
        // $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
        $data ['engpemadams'] = $connpemadam->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistPemadamH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPemadamH());
        $conndetail = ConnectionDB::setConnection(new ChecklistPemadamDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $pemadam = ConnectionDB::setConnection(new EngPemadam ());

            $id_pemadam = $pemadam->first('id_eng_pemadam');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_pemadam = $id_pemadam->id_eng_pemadam . $today . $current;

            
            $conn->create([
                'id_eng_checklist_pemadam' => $request->id_eng_checklist_pemadam,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_pemadam' => $no_checklist_pemadam
            ]);

            $conndetail->create([
                'id_eng_pemadam' => $request->count,
                'no_checklist_pemadam' => $no_checklist_pemadam,
                'check_point1' => $request->check_point1,
                'check_point2' => $request->check_point2,
                'check_point3' => $request->check_point3,
                'check_point4' => $request->check_point4,
                'check_point5' => $request->check_point5,
                'check_point6' => $request->check_point6,
                'check_point7' => $request->check_point7,
                'check_point8' => $request->check_point8,
                'check_point9' => $request->check_point9,
                'check_point10' => $request->check_point10,
                'check_point11' => $request->check_point11,
                'check_point12' => $request->check_point12,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Pemadam');

            return redirect()->route('checklistpemadams.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis Pemadam');

            return redirect()->route('checklistpemadams.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPemadamH());
            $conndetail = ConnectionDB::setConnection(new ChecklistPemadamDetail());
            $user_id = $request->user()->id;
    
            $data['checklistpemadam'] = $conn->where('no_checklist_pemadam', $id)->first();
            $data['pemadamdetail'] = $conndetail->where('no_checklist_pemadam', $id)->first();
            $data['idusers'] =  Login::where('id', $user_id)->get();
            
            return view('AdminSite.ChecklistPemadamH.show',$data);
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
