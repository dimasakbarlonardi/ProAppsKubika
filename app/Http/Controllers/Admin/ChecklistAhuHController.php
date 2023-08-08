<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAhuH;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistAhuDetail;
use App\Models\EngAhu;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
   
class ChecklistAhuHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());
        $connahudetail = ConnectionDB::setConnection(new ChecklistAhuDetail());
        $user_id = $request->user()->id;

        $data['checklistahus'] = $conn->get();
        $data['ahudetails'] = $connahudetail->first();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());


        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_ahu) {
            $data = $data->where('no_checklist_ahu', $request->no_checklist_ahu);
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
        $connahu = ConnectionDB::setConnection(new EngAhu());
        $user_id = $request->user()->id;


        $data['rooms'] = $connroom->get();
        $data['engahus'] = $connahu->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());
        $conndetail = ConnectionDB::setConnection(new ChecklistAhuDetail());

        try {

            DB::beginTransaction();

            $ahu = ConnectionDB::setConnection(new EngAhu());

            $id_ahu = $ahu->first('id_eng_ahu');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('Y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_ahu = $id_ahu->id_eng_ahu . $today . $current;


            $conn->create([
                'id_checklist_ahu_h' => $request->id_checklist_ahu_h,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                // 'id_user' => $request->id_user,
                'no_checklist_ahu' => $no_checklist_ahu,
            ]);

            $conndetail->create([
                'id_ahu' => $request->id_ahu,
                'no_checklist_ahu' => $no_checklist_ahu,
                'in_out' => $request->in_out,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);


            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis AHU');

            return redirect()->route('checklistahus.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis AHU');

            return redirect()->route('checklistahus.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());
        $conndetail = ConnectionDB::setConnection(new ChecklistAhuDetail());
        $user_id = $request->user()->id;

        $data['checklistahu'] = $conn->where('no_checklist_ahu', $id)->first();
        $data['ahudetail'] = $conndetail->where('no_checklist_ahu', $id)->first();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());
        $conndetail = ConnectionDB::setConnection(new ChecklistAhuDetail());
        $connroom = ConnectionDB::setConnection(new Room());
        $user_id = $request->user()->id;

        $data['checklistahu'] = $conn->where('no_checklist_ahu', $id)->first();
        $data['ahudetail'] = $conndetail->where('no_checklist_ahu', $id)->first();
        $data['rooms'] = $connroom->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

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
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());

        $checklistahu = $conn->find($id);
        $checklistahu->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Checklis AHU');

        return redirect()->route('checklistahus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());

        $conn->find($id)->delete();
        Alert::success('Berhasil', 'Berhasil Menghapus Checklist AHU');

        return redirect()->route('checklistahus.index');
    }
}
