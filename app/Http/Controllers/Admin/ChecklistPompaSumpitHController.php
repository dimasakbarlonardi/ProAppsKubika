<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistPompaSumpitH;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistPompaSumpitDetail;
use App\Models\EngPompasumpit;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistPompaSumpitHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPompaSumpitH());
        $user_id = $request->user()->id;
        
        $data ['checklistpompasumpits'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistPompaSumpitH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPompaSumpitH());

       
        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {     
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_pompa_sumpit) {
            $data = $data->where('no_checklist_pompa_sumpit', $request->no_checklist_pompa_sumpit);
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
        $connpompasumpit = ConnectionDB::setConnection(new EngPompasumpit());
        $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
        $data ['engpompasumpits'] = $connpompasumpit->get();
        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistPompaSumpitH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPompaSumpitH());
        $conndetail = ConnectionDB::setConnection(new ChecklistPompaSumpitDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $pompasumpit = ConnectionDB::setConnection(new EngPompasumpit());

            $id_pompasumpit = $pompasumpit->first('id_eng_pompasumpit');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_pompa_sumpit = $id_pompasumpit->id_eng_pompasumpit . $today . $current;

            
            $conn->create([
                'id_eng_checklist_pompasumpit' => $request->id_eng_checklist_pompasumpit,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_pompa_sumpit' => $no_checklist_pompa_sumpit
            ]);

            $conndetail->create([
                'id_eng_pompa_sumpit' => $request->id_eng_pompa_sumpit,
                'no_checklist_pompa_sumpit' => $no_checklist_pompa_sumpit,
                'check_point1' => $request->check_point1,
                'check_point2' => $request->check_point2,
                'check_point3' => $request->check_point3,
                'check_point4' => $request->check_point4,
                'check_point5' => $request->check_point5,
                'check_point6' => $request->check_point6,
                'check_point7' => $request->check_point7,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Pompa sumpit');

            return redirect()->route('checklistpompasumpits.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis Pompa sumpit');

            return redirect()->route('checklistpompasumpits.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistPompaSumpitH());
        $conndetail = ConnectionDB::setConnection(new ChecklistPompaSumpitDetail());
        $user_id = $request->user()->id;

        $data['checklistpompasumpit'] = $conn->where('no_checklist_pompa_sumpit', $id)->first();
        $data['pompasumpitdetail'] = $conndetail->where('no_checklist_pompa_sumpit', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistPompaSumpitH.show',$data);
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
