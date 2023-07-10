<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistChillerH;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistChillerDetail;
use App\Models\EngChiller;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChecklistChillerHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistChillerH());
        $user_id = $request->user()->id;
        
        $data ['checklistchillers'] = $conn->get();
        $data ['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistChillerH.index', $data);

    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistChillerH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_chiller) {
            $data = $data->where('no_checklist_chiller', $request->no_checklist_chiller);
        }
        $data = $data->get();

        return response()->json(['checklists' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $connroom = ConnectionDB::setConnection(new Room());
        $connahu = ConnectionDB::setConnection(new EngChiller());
        $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
        $data ['engchillers'] = $connahu->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistChillerH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistChillerH());
        $conndetail = ConnectionDB::setConnection(new ChecklistChillerDetail());

        try {
            
            DB::beginTransaction();

            $ahu = ConnectionDB::setConnection(new EngChiller());

            $id_chiller = $ahu->first('id_eng_chiller');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_chiller = $id_chiller->id_eng_chiller . $today . $current;

            
            $conn->create([
                'id_eng_checklist_chiller' => $request->id_eng_checklist_chiller,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                // 'id_user' => $request->id_user,
                'no_checklist_chiller' => $no_checklist_chiller
            ]);

            $conndetail->create([
                'id_eng_chiller' => $request->id_eng_chiller,
                'no_checklist_chiller' => $no_checklist_chiller,
                'in_out' => $request->in_out,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Chiller');

            return redirect()->route('checklistchillers.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis Chiller');

            return redirect()->route('checklistchillers.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistChillerH());
        $conndetail = ConnectionDB::setConnection(new ChecklistChillerDetail());
        $user_id = $request->user()->id;

        $data['checklistchiller'] = $conn->where('no_checklist_chiller', $id)->first();
        $data['chillerdetail'] = $conndetail->where('no_checklist_chiller', $id)->first();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistChillerH.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistChillerH());
        // $conndetail = ConnectionDB::setConnection(new ChecklistAhuDetail()); 
        $connroom = ConnectionDB::setConnection(new Room());
        $user_id = $request->user()->id;

        $data['checklistahu'] = $conn->where('no_checklist_ahu', $id)->first();
        // $data['ahudetail'] = $conndetail->where('no_checklist_ahu', $id)->first();
        $data ['rooms'] = $connroom->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.edit', $data);
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
        $conn = ConnectionDB::setConnection(new ChecklistChillerH());

        $checklistchiller = $conn->find($id);
        $checklistchiller->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Checklis Chiller');

        return redirect()->route('checklistchillers.index');
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
