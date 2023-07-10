<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistListrikH;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistListrikDetail;
use App\Models\EngListrik;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use PgSql\Lob;

class ChecklistListrikHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikH());
        $user_id = $request->user()->id;
        
        $data ['checklistlistriks'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistListrikH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikH());

      
        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_listrik) {
            $data = $data->where('no_checklist_listrik', $request->no_checklist_listrik);
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
        $connlistrik = ConnectionDB::setConnection(new EngListrik());
        // $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
        $data ['englistriks'] = $connlistrik->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistListrikH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikH());
        $conndetail = ConnectionDB::setConnection(new ChecklistListrikDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $listrik = ConnectionDB::setConnection(new EngListrik());

            $id_listrik = $listrik->first('id_eng_listrik');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_listrik = $id_listrik->id_eng_listrik . $today . $current;

            
            $conn->create([
                'id_eng_checklist_listrik' => $request->id_eng_checklist_listrik,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_listrik' => $no_checklist_listrik
            ]);

            $conndetail->create([
                'id_eng_listrik' => $request->count,
                'no_checklist_listrik' => $no_checklist_listrik,
                'nilai' => $request->nilai,
                'hasil' => $request->hasil,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Listrik');

            return redirect()->route('checklistlistriks.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis Listrik');

            return redirect()->route('checklistlistriks.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistListrikH());
        $conndetail = ConnectionDB::setConnection(new ChecklistListrikDetail());
        $user_id = $request->user()->id;

        $data['checklistlistrik'] = $conn->where('no_checklist_listrik', $id)->first();
        $data['listrikdetail'] = $conndetail->where('no_checklist_listrik', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistListrikH.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,$id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikH());
        $conndetail = ConnectionDB::setConnection(new ChecklistListrikDetail());
        $connroom = ConnectionDB::setConnection(new Room());
        $user_id = $request->user()->id;

        $data['checklistlistrik'] = $conn->where('no_checklist_listrik', $id)->first();
        $data['listrikdetail'] = $conndetail->get();
        $data ['rooms'] = $connroom->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistListrikH.edit', $data);
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
        $conn = ConnectionDB::setConnection(new ChecklistListrikH());

        $checklistlistrik = $conn->find($id);
        $checklistlistrik->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Checklis Listrik');

        return redirect()->route('checklistlistriks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikH());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Checklist Listrik');

        return redirect()->route('checklistlistriks.index');
    }
}
