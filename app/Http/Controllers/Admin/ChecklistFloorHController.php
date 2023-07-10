<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\ChecklistFloorDetail;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ChecklistFloorH;
use App\Models\HKFloor;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChecklistFloorHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistFloorH());
        $user_id = $request->user()->id;
        
        $data ['checklistfloors'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistFloorH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistFloorH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_floor) {
            $data = $data->where('no_checklist_floor', $request->no_checklist_floor);
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
        $connfloor = ConnectionDB::setConnection(new HKFloor());
        
        $data ['rooms'] = $connroom->get();
        $data ['engfloor'] = $connfloor->get();

        return view('AdminSite.ChecklistFloorH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistFloorH());
        $conndetail = ConnectionDB::setConnection(new ChecklistFloorDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $floor = ConnectionDB::setConnection(new HKFloor());

            $id_floor = $floor->first('id_hk_floor');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_floor = $id_floor->id_hk_floor . $today . $current;

            
            $conn->create([
                'id_eng_checklist_floor' => $request->id_eng_checklist_floor,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_floor' => $no_checklist_floor,
                'periode' => $request->periode
            ]);

            $conndetail->create([
                'id_eng_floor' => $request->count,
                'no_checklist_floor' => $no_checklist_floor,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Floor');

            return redirect()->route('checklistfloors.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis floor');

            return redirect()->route('checklistfloors.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistFloorH());
        $conndetail = ConnectionDB::setConnection(new ChecklistFloorDetail());
        $user_id = $request->user()->id;

        $data['checklistfloor'] = $conn->where('no_checklist_floor', $id)->first();
        $data['floordetail'] = $conndetail->where('no_checklist_floor', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistFloorH.show',$data);
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
