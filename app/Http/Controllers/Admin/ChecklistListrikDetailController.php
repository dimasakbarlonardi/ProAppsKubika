<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistListrikDetail;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistListrikDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikDetail());

        $data ['listrikdetails'] = $conn->get();

        return view('AdminSite.ChecklistListrikDetail.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.ChecklistListrikDetail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikDetail());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_eng_listrik' => $request->id_eng_listrik,
                'no_checklist_listrik' => $request->no_checklist_listrik,
                'nilai' => $request->nilai,
                'hasil' => $request->hasil,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis listrik');

            return redirect()->route('listrikdetails.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis listrik');

            return redirect()->route('listrikdetails.index');
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
    public function edit($id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikDetail());

        $data['listrikdetail'] = $conn->find($id);

        return view('AdminSite.ChecklistListrikDetail.edit', $data);
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
        $conn = ConnectionDB::setConnection(new ChecklistListrikDetail());

        $listrikdetail = $conn->find($id);
        $listrikdetail->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Checklis Listrik');

        return redirect()->route('listrikdetails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistListrikDetail());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Checklist Listrik');

        return redirect()->route('listrikdetails.index');
    }
}
