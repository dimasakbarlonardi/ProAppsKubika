<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\StatusAktifKaryawan;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class StatusAktifKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new StatusAktifKaryawan());

        $data['statusaktifkaryawans'] = $conn->get();

        return view('AdminSite.StatusAktifKaryawan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.StatusAktifKaryawan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new StatusAktifKaryawan());

        try {
            DB::beginTransaction();

            $conn->create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan status aktif karyawan');

            return redirect()->route('statusaktifkaryawans.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan status aktif karyawan');

            return redirect()->route('statusaktifkaryawans.index');
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
        $conn = ConnectionDB::setConnection(new StatusAktifKaryawan());

        $data['statusaktifkaryawan'] = $conn->where('id_status_aktif_karyawan',$id)->first();

        return view('AdminSite.StatusAktifKaryawan.edit', $data);
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
        $conn = ConnectionDB::setConnection(new StatusAktifKaryawan());

        $statuskawin = $conn->find($id);

        $statuskawin->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate status aktif karyawan');

        return redirect()->route('statusaktifkaryawans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new StatusAktifKaryawan());

        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus status aktif karyawan');

        return redirect()->route('statusaktifkaryawans.index');
    }
}
