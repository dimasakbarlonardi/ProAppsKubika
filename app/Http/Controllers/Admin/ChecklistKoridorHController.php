<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\ChecklistKoridorDetail;
use App\Models\ChecklistKoridorH;
use App\Models\HKKoridor;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ChecklistKoridorHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistKoridorH());
        $user_id = $request->user()->id;
        
        $data ['checklistkoridors'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistKoridorH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistKoridorH());

        $data = $conn->where('no_checklist_koridor', $request->no_checklist_koridor)
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
        $connkoridor = ConnectionDB::setConnection(new HKKoridor());
        
        $data ['rooms'] = $connroom->get();
        $data ['engkoridors'] = $connkoridor->get();

        return view('AdminSite.ChecklistKoridorH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistKoridorH());
        $conndetail = ConnectionDB::setConnection(new ChecklistKoridorDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $koridor = ConnectionDB::setConnection(new HKKoridor());

            $id_koridor = $koridor->first('id_hk_koridor');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_koridor = $id_koridor->id_hk_koridor . $today . $current;

            
            $conn->create([
                'id_eng_checklist_koridor' => $request->id_eng_checklist_koridor,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_koridor' => $no_checklist_koridor
            ]);

            $conndetail->create([
                'id_eng_koridor' => $request->count,
                'no_checklist_koridor' => $no_checklist_koridor,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Koridor');

            return redirect()->route('checklistkoridors.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis Koridor');

            return redirect()->route('checklistkoridors.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistKoridorH());
        $conndetail = ConnectionDB::setConnection(new ChecklistKoridorDetail());
        $user_id = $request->user()->id;

        $data['checklistkoridor'] = $conn->where('no_checklist_koridor', $id)->first();
        $data['koridordetail'] = $conndetail->where('no_checklist_koridor', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistKoridorH.show',$data);
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
