<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistGensetH;
use Illuminate\Support\Facades\DB;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistGensetDetail;
use App\Models\EngGas;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistGensetHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistGensetH());
        $user_id = $request->user()->id;
        
        $data ['checklistgensets'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistGensetH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistGensetH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_genset) {
            $data = $data->where('no_checklist_genset', $request->no_checklist_genset);
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
        // $conngenset = ConnectionDB::setConnection(new EngGenset());
        // $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
        // $data ['enggensets'] = $conngenset->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistGensetH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //     $conn = ConnectionDB::setConnection(new ChecklistGasH());
    //     $conndetail = ConnectionDB::setConnection(new ChecklistGasDetail());

    //     try {
            
    //         DB::beginTransaction();

    //         $id_user = $request->user()->id;
    //         $login = Login::where('id', $id_user)->with('site')->first();

    //         // $gas = ConnectionDB::setConnection(new EngGenset 

    //         // $id_gas = $gas->first('id_eng_gas');

    //         $today = Carbon::now()->format('dmY');

    //         $tgl = Carbon::now()->format('y-m-d');

    //         $current = Carbon::now()->format('hi');

    //         $time = Carbon::now()->format('his');

    //         // $no_checklist_genset = $id_gas->id_eng_gas . $today . $current;

            
    //         $conn->create([
    //             'id_eng_checklist_gas' => $request->id_eng_checklist_gas,
    //             'barcode_room' => $request->barcode_room,
    //             'id_room' => $request->id_room,
    //             'tgl_checklist' => $tgl,
    //             'time_checklist' => $time,
    //             'id_user' => $id_user,
    //             'no_checklist_gas' => $no_checklist_genset
    //         ]);

    //         $conndetail->create([
    //             'id_eng_gas' => $request->count,
    //             'no_checklist_gas' => $no_checklist_genset,
    //             'check_point1' => $request->check_point1,
    //             'check_point2' => $request->check_point2,
    //             'check_point3' => $request->check_point3,
    //             'check_point4' => $request->check_point4,
    //             'check_point5' => $request->check_point5,
    //             'check_point6' => $request->check_point6,
    //             'keterangan' => $request->keterangan,
    //         ]);
           
            
    //         DB::commit();

    //         Alert::success('Berhasil', 'Berhasil menambahkan Checklis Genset');

    //         return redirect()->route('checklistgensets.index');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         dd($e);
    //         Alert::error('Gagal', 'Gagal menambahkan Checklis Genset');

    //         return redirect()->route('checklistgensets.index');
    //     }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$id)
    {
    //     $conn = ConnectionDB::setConnection(new ChecklistGensetH());
    //     $conndetail = ConnectionDB::setConnection(new ChecklistGensetDetail());
    //     $user_id = $request->user()->id;

    //     $data['checklistgenset'] = $conn->where('no_checklist_genset', $id)->first();
    //     $data['gensetdetail'] = $conndetail->where('no_checklist_genset', $id)->first();
    //     $data['idusers'] =  Login::where('id', $user_id)->get();
        
    //     return view('AdminSite.ChecklistGensetH.show',$data);
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
