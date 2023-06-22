<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistChillerDetail;
use Illuminate\Support\Facades\DB;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistChillerH;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistChilerDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ChecklistChillerDetail());

        $data ['chillerdetails'] = $conn->get();

        return view('AdminSite.ChecklistChillerDetail.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.ChecklistChillerDetail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistChillerDetail());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_eng_chiller' => $request->id_eng_chiller,
                'no_checklist_chiller' => $request->no_checklist_chiller,
                'in_out' => $request->in_out,
                'check_point' => $request->check_point,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis Chiller');

            return redirect()->route('chillerdetails.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis Chiller');

            return redirect()->route('chillerdetails.index');
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
    public function edit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistChillerDetail());

        $data['chillerdetail'] = $conn->find($id);

        return view('AdminSite.ChecklistChillerDetail.edit', $data);
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
        $conn = ConnectionDB::setConnection(new ChecklistChillerDetail());

        $ahudetail = $conn->find($id);
        $ahudetail->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Checklis Chiller');

        return redirect()->route('chillerdetails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistChillerDetail());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Checklist Chiller');

        return redirect()->route('chillerdetails.index');
    }
}
