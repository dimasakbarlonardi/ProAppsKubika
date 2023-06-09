<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAhuH;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistAhuDetail;
use App\Models\Login;
use App\Models\Room;
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
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());
        $connahudetail = ConnectionDB::setConnection(new ChecklistAhuDetail());

        $data ['checklistahus'] = $conn->get();
        $data ['ahudetails'] = $connahudetail->get();

        return view('AdminSite.ChecklistAhuH.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $connroom = ConnectionDB::setConnection(new Room());
        $user_id = $request->user()->id;

        
        $data ['rooms'] = $connroom->get();
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

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_checklist_ahu_h' => $request->id_checklist_ahu_h,
                'barcode_room' => $request->barcode_room,
                'id_room' => $request->id_room,
                'tgl_checklist' => $request->tgl_checklist,
                'time_checklist' => $request->time_checklist,
                'id_user' => $request->id_user,
                'no_checklist_ahu' => $request->no_checklist_ahu,
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,$id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());
        $connroom = ConnectionDB::setConnection(new Room());
        $user_id = $request->user()->id;

        
        
        $data['checklistahu'] = $conn->find($id);
        $data ['rooms'] = $connroom->get();
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
        Alert::success('Berhasil','Berhasil Menghapus Checklist AHU');

        return redirect()->route('checklistahus.index');
    }
}
