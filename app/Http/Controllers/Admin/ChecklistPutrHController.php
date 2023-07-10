<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistPutrDetail;
use App\Models\ChecklistPutrH;
use App\Models\EngPutr;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistPutrHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPutrH());
        $user_id = $request->user()->id;
        
        $data ['checklistputrs'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistPutrH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPutrH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_putr) {
            $data = $data->where('no_checklist_putr', $request->no_checklist_putr);
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
        $connputr = ConnectionDB::setConnection(new EngPutr());
        // $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
        $data ['engputrs'] = $connputr->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistPutrH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPutrH());
        $conndetail = ConnectionDB::setConnection(new ChecklistPutrDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $putr = ConnectionDB::setConnection(new EngPutr());

            $id_putr = $putr->first('id_eng_putr');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_putr = $id_putr->id_eng_putr . $today . $current;

            
            $conn->create([
                'id_eng_checklist_putr' => $request->id_eng_checklist_putr,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_putr' => $no_checklist_putr
            ]);

            $conndetail->create([
                'id_eng_putr' => $request->count,
                'no_checklist_putr' => $no_checklist_putr,
                'check_point1' => $request->check_point1,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis putr');

            return redirect()->route('checklistputrs.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis putr');

            return redirect()->route('checklistputrs.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistPutrH());
        $conndetail = ConnectionDB::setConnection(new ChecklistPutrDetail());
        $user_id = $request->user()->id;

        $data['checklistputr'] = $conn->where('no_checklist_putr', $id)->first();
        $data['putrdetail'] = $conndetail->where('no_checklist_putr', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistPutrH.show',$data);
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
