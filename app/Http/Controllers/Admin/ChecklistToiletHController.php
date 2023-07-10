<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistToiletDetail;
use App\Models\ChecklistToiletH;
use App\Models\Login;
use App\Models\Room;
use App\Models\Toilet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistToiletHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistToiletH());
        $user_id = $request->user()->id;
        
        $data ['checklisttoilets'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistToiletH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistToiletH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_toilet) {
            $data = $data->where('no_checklist_toilet', $request->no_checklist_toilet);
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
        $conntoilet = ConnectionDB::setConnection(new Toilet());
        
        $data ['rooms'] = $connroom->get();
        $data ['engtoilets'] = $conntoilet->get();

        return view('AdminSite.ChecklistToiletH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistToiletH());
        $conndetail = ConnectionDB::setConnection(new ChecklistToiletDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $toilet = ConnectionDB::setConnection(new Toilet());

            $id_toilet = $toilet->first('id_hk_toilet');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_toilet = $id_toilet->id_hk_toilet . $today . $current;

            
            $conn->create([
                'id_eng_checklist_toilet' => $request->id_eng_checklist_toilet,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_toilet' => $no_checklist_toilet
            ]);

            $conndetail->create([
                'id_eng_toilet' => $request->count,
                'no_checklist_toilet' => $no_checklist_toilet,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis toilet');

            return redirect()->route('checklisttoilets.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis toilet');

            return redirect()->route('checklisttoilets.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistToiletH());
        $conndetail = ConnectionDB::setConnection(new ChecklistToiletDetail());
        $user_id = $request->user()->id;

        $data['checklisttoilet'] = $conn->where('no_checklist_toilet', $id)->first();
        $data['toiletdetail'] = $conndetail->where('no_checklist_toilet', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistToiletH.show',$data);
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
