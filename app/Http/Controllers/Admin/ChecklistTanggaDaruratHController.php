<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistTanggaDaruratDetail;
use App\Models\ChecklistTanggaDaruratH;
use App\Models\HKTanggaDarurat;
use App\Models\Login;
use App\Models\Room;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistTanggaDaruratHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistTanggaDaruratH());
        $user_id = $request->user()->id;
        
        $data ['checklisttanggadarurats'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistTanggaDaruratH.index', $data);
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistTanggaDaruratH());

        $data = $conn->where('no_checklist_tangga_darurat', $request->no_checklist_tangga_darurat)
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
        $conntanggadarurat = ConnectionDB::setConnection(new HKTanggaDarurat());
        
        $data ['rooms'] = $connroom->get();
        $data ['engtanggadarurats'] = $conntanggadarurat->get();

        return view('AdminSite.ChecklistTanggaDaruratH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistTanggaDaruratH());
        $conndetail = ConnectionDB::setConnection(new ChecklistTanggaDaruratDetail());

        try {
            
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $tanggadarurat = ConnectionDB::setConnection(new HKTanggaDarurat());

            $id_tanggadarurat = $tanggadarurat->first('id_hk_tangga_darurat');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_tangga_darurat = $id_tanggadarurat->id_hk_tangga_darurat . $today . $current;

            
            $conn->create([
                'id_eng_checklist_tangga_darurat' => $request->id_eng_checklist_tangga_darurat,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $tgl,
                'time_checklist' => $time,
                'id_user' => $id_user,
                'no_checklist_tangga_darurat' => $no_checklist_tangga_darurat
            ]);

            $conndetail->create([
                'id_eng_tangga_darurat' => $request->count,
                'no_checklist_tangga_darurat' => $no_checklist_tangga_darurat,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);
           
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis tangga darurat');

            return redirect()->route('checklisttanggadarurats.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis tangga darurat');

            return redirect()->route('checklisttanggadarurats.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistTanggaDaruratH());
        $conndetail = ConnectionDB::setConnection(new ChecklistTanggaDaruratDetail());
        $user_id = $request->user()->id;

        $data['checklisttanggadarurat'] = $conn->where('no_checklist_tangga_darurat', $id)->first();
        $data['tanggadaruratdetail'] = $conndetail->where('no_checklist_tangga_darurat', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();
        
        return view('AdminSite.ChecklistTanggaDaruratH.show',$data);
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
