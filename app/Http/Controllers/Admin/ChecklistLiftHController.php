<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\ChecklistLiftDetail;
use App\Models\ChecklistLiftH;
use App\Models\Lift;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ChecklistLiftHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistLiftH());
        $user_id = $request->user()->id;
        
        $data ['checklistlifts'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistLiftH.index', $data);
    }

    
    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistLiftH());

        $data = $conn->where('no_checklist_lift', $request->no_checklist_lift)
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
        $connlift = ConnectionDB::setConnection(new Lift());
        
        $data ['rooms'] = $connroom->get();
        $data ['englifts'] = $connlift->get();

        return view('AdminSite.ChecklistLiftH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistLiftH());
        $conndetail = ConnectionDB::setConnection(new ChecklistLiftDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $lift = ConnectionDB::setConnection(new Lift());

            $id_lift = $lift->first('id_hk_lift');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_lift = $id_lift->id_hk_lift . $today . $current;

            
            $conn->create([
                'id_eng_checklist_lift' => $request->id_eng_checklist_lift,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_lift' => $no_checklist_lift,
                'periode' => $request->periode
            ]);

            $conndetail->create([
                'id_eng_lift' => $request->count,
                'no_checklist_lift' => $no_checklist_lift,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis lift');

            return redirect()->route('checklistlifts.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis lift');

            return redirect()->route('checklistlifts.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistLiftH());
        $conndetail = ConnectionDB::setConnection(new ChecklistLiftDetail());
        $user_id = $request->user()->id;

        $data['checklistlift'] = $conn->where('no_checklist_lift', $id)->first();
        $data['liftdetail'] = $conndetail->where('no_checklist_lift', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistLiftH.show',$data);
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
