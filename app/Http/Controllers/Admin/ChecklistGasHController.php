<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistGasDetail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\ChecklistGasH;
use App\Models\EngGas;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChecklistGasHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistGasH());
        $user_id = $request->user()->id;
        
        $data ['checklistgases'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistGasH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistGasH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_gas) {
            $data = $data->where('no_checklist_gas', $request->no_checklist_gas);
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
        $conngas = ConnectionDB::setConnection(new EngGas());
        // $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
        $data ['enggases'] = $conngas->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistGasH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistGasH());
        $conndetail = ConnectionDB::setConnection(new ChecklistGasDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $gas = ConnectionDB::setConnection(new EngGas ());

            $id_gas = $gas->first('id_eng_gas');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_gas = $id_gas->id_eng_gas . $today . $current;

            
            $conn->create([
                'id_eng_checklist_gas' => $request->id_eng_checklist_gas,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_gas' => $no_checklist_gas
            ]);

            $conndetail->create([
                'id_eng_gas' => $request->count,
                'no_checklist_gas' => $no_checklist_gas,
                'data1' => $request->data1,
                'data2' => $request->data2,
                'data3' => $request->data3,
                'data4' => $request->data4,
                'total1' => $request->total1,
                'total2' => $request->total2,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Gas');

            return redirect()->route('checklistgases.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis Gas');

            return redirect()->route('checklistgases.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistGasH());
        $conndetail = ConnectionDB::setConnection(new ChecklistGasDetail());
        $user_id = $request->user()->id;

        $data['checklistgas'] = $conn->where('no_checklist_gas', $id)->first();
        $data['gasdetail'] = $conndetail->where('no_checklist_gas', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistGasH.show',$data);
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
