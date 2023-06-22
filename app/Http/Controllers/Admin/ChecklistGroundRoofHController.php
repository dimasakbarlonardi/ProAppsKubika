<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistGroundRoofDetail;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ChecklistGroundRoofH;
use App\Models\EngGroundrofftank;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChecklistGroundRoofHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ChecklistGroundRoofH());
        
        $data ['checklistgroundroofs'] = $conn->get();
        
        return view('AdminSite.ChecklistGroundRoofH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistGroundRoofH());

        $data = $conn->where('no_checklist_tank', $request->no_checklist_tank)
        ->whereBetween('tgl_checklist', [$request->date_from, $request->date_to])
        ->get();

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
        $conngroundroof = ConnectionDB::setConnection(new EngGroundrofftank());
        $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
        $data ['enggroundrooftanks'] = $conngroundroof->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistGroundRoofH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistGroundRoofH());
        $conndetail = ConnectionDB::setConnection(new ChecklistGroundRoofDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $groundroof = ConnectionDB::setConnection(new EngGroundrofftank());

            $id_groundroof = $groundroof->first('id_eng_groundrofftank');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_groundroof = $id_groundroof->id_eng_groundrofftank . $today . $current;

            
            $conn->create([
                'id_eng_checklist_groundroof' => $request->id_eng_checklist_groundroof,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_tank' => $no_checklist_groundroof
            ]);

            $conndetail->create([
                'id_eng_groundrooftank' => $request->count,
                'no_checklist_tank' => $no_checklist_groundroof,
                'check_point1' => $request->check_point1,
                'check_point2' => $request->check_point2,
                'check_point3' => $request->check_point3,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Ground Roof');

            return redirect()->route('checklistgroundroofs.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis Ground Roof');

            return redirect()->route('checklistgroundroofs.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistGroundRoofH());
        $conndetail = ConnectionDB::setConnection(new ChecklistGroundRoofDetail());
        $user_id = $request->user()->id;

        $data['checklistgroundroof'] = $conn->where('no_checklist_tank', $id)->first();
        $data['groundroofdetail'] = $conndetail->where('no_checklist_tank', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistGroundRoofH.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,$id)
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
