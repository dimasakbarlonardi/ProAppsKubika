<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistSolarH;
use App\Helpers\ConnectionDB;
use App\Models\Login;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistSolarHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistSolarH());
        $user_id = $request->user()->id;
        
        $data ['checklistsolars'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistSolarH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistSolarH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_solar) {
            $data = $data->where('no_checklist_solar', $request->no_checklist_solar);
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
        // $connsolar = ConnectionDB::setConnection(new EngSolar());
        
        $data ['rooms'] = $connroom->get();
        // $data ['engsolars'] = $connsolar->get();

        return view('AdminSite.ChecklistSolarH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $conn = ConnectionDB::setConnection(new ChecklistSolarH());
        // // $conndetail = ConnectionDB::setConnection(new ChecklistSolarDetail());

        // try {
            
        //     DB::beginTransaction();

        //     $id_user = $request->user()->id;
        //     $login = Login::where('id', $id_user)->with('site')->first();

        //     $solar = ConnectionDB::setConnection(new EngSolar());

        //     $id_solar = $solar->first('id_eng_solar');

        //     $today = Carbon::now()->format('dmY');

        //     $tgl = Carbon::now()->format('y-m-d');

        //     $current = Carbon::now()->format('hi');

        //     $time = Carbon::now()->format('his');

        //     $no_checklist_solar = $id_solar->id_eng_solar . $today . $current;

            
        //     $conn->create([
        //         'id_eng_checklist_solar' => $request->id_eng_checklist_solar,
        //         'barcode_room' => $request->barcode_room,
        //         'id_room' => $request->id_room,
        //         'tgl_checklist' => $tgl,
        //         'time_checklist' => $time,
        //         'id_user' => $id_user,
        //         'no_checklist_solar' => $no_checklist_solar
        //     ]);

        //     $conndetail->create([
        //         'id_eng_solar' => $request->count,
        //         'no_checklist_solar' => $no_checklist_solar,
        //         'nilai' => $request->nilai,
        //         'hasil' => $request->hasil,
        //         'keterangan' => $request->keterangan,
        //     ]);
           
            
        //     DB::commit();

        //     Alert::success('Berhasil', 'Berhasil menambahkan Checklis solar');

        //     return redirect()->route('checklistsolars.index');
        // } catch (\Throwable $e) {
        //     DB::rollBack();
        //     dd($e);
        //     Alert::error('Gagal', 'Gagal menambahkan Checklis solar');

        //     return redirect()->route('checklistsolars.index');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistSolarH());
        // $conndetail = ConnectionDB::setConnection(new ChecklistSolarDetail());
        $user_id = $request->user()->id;

        $data['checklistsolar'] = $conn->where('no_checklist_solar', $id)->first();
        // $data['solardetail'] = $conndetail->where('no_checklist_solar', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistSolarH.show',$data);
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
