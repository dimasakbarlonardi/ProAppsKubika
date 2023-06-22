<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeManagement;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class OfficeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new OfficeManagement());

        $data ['officemanagements'] = $conn->get();

        return view('AdminSite.OfficeManagement.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.OfficeManagement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new OfficeManagement());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_hk_office' => $request->id_hk_office,
                'nama_hk_office' => $request->nama_hk_office,
                'subject' => $request->subject,
                'periode' => $request->periode,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan HK Office Management');

            return redirect()->route('officemanagements.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan HK Office Management');

            return redirect()->route('officemanagements.index');
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
        $conn = ConnectionDB::setConnection(new OfficeManagement());

        $data['officemang'] = $conn->find($id);

        return view('AdminSite.OfficeManagement.edit', $data);
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
        $conn = ConnectionDB::setConnection(new OfficeManagement());

        $office = $conn->find($id);
        $office->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate HK Office Management');

        return redirect()->route('officemanagements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new OfficeManagement());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus HK Office Management');

        return redirect()->route('officemanagements.index');
    }
}
