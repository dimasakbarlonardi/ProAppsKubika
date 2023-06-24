<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistTemperaturDetail;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ChecklistTemperaturH;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChecklistTemperaturHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistTemperaturH());
        $user_id = $request->user()->id;
        
        $data ['checklisttemperaturs'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistTemperaturH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistTemperaturH());

        $data = $conn->where('no_checklist_suhu', $request->no_checklist_suhu)
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
        
        $data ['rooms'] = $connroom->get();

        return view('AdminSite.ChecklistTemperaturH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //      $conn = ConnectionDB::setConnection(new ChecklistTemperaturH());
    //     // $conndetail = ConnectionDB::setConnection(new ChecklistTemperaturDetail());

    //     try {
            
    //         DB::beginTransaction();

    //         $id_user = $request->user()->id;
    //         $login = Login::where('id', $id_user)->with('site')->first();

    //         $solar = ConnectionDB::setConnection(new EngTemperatur());

    //         $id_solar = $solar->first('id_eng_solar');

    //         $today = Carbon::now()->format('dmY');

    //         $tgl = Carbon::now()->format('y-m-d');

    //         $current = Carbon::now()->format('hi');

    //         $time = Carbon::now()->format('his');

    //         $no_checklist_temperatur = $id_solar->id_eng_solar . $today . $current;

            
    //         $conn->create([
    //             'id_eng_checklist_temperatur' => $request->id_eng_checklist_temperatur,
    //             'barcode_room' => $request->barcode_room,
    //             'id_room' => $request->id_room,
    //             'tgl_checklist' => $tgl,
    //             'time_checklist' => $time,
    //             'id_user' => $id_user,
    //             'no_checklist_temperatur' => $no_checklist_temperatur
    //         ]);

    //         $conndetail->create([
    //             'id_eng_solar' => $request->count,
    //             'no_checklist_solar' => $no_checklist_temperatur,
    //             'check_point1' => $request->check_point1,
    //             'check_point2' => $request->check_point2,
    //             'check_point3' => $request->check_point3,
    //             'check_point4' => $request->check_point4,
    //             'check_point5' => $request->check_point5,
    //             'check_point6' => $request->check_point6,
    //             'jam' => $request->jam,
    //             'keterangan' => $request->keterangan,
    //         ]);
           
            
    //         DB::commit();

    //         Alert::success('Berhasil', 'Berhasil menambahkan Checklis Temperatur');

    //         return redirect()->route('checklisttemperaturs.index');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         dd($e);
    //         Alert::error('Gagal', 'Gagal menambahkan Checklis Temperatur');

    //         return redirect()->route('checklisttemperaturs.index');
    //     }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistTemperaturH());
        // $conndetail = ConnectionDB::setConnection(new ChecklistTemperaturDetail());
        $user_id = $request->user()->id;

        $data['checklistsolar'] = $conn->where('no_checklist_solar', $id)->first();
        // $data['temperaturdetail'] = $conndetail->where('no_checklist_temperatur', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistTemperaturH.show',$data);
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
