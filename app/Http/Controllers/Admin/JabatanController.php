<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Jabatan());
        $data['jabatans'] = $conn->get();

        return view('AdminSite.Jabatan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Jabatan());

        try {
            DB::beginTransaction();

            $conn->create([
                'id_jabatan' => $request->id_jabatan,
                'nama_jabatan' => $request->nama_jabatan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan jabatan');

            return redirect()->route('jabatans.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan jabatan');

            return redirect()->route('jabatans.index');
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
        $conn = ConnectionDB::setConnection(new Jabatan());

        $data['jabatan'] = $conn->find($id);

        return view('AdminSite.Jabatan.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Jabatan());

        $jabatan = $conn->find($id);
        $jabatan->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate jabatan');

        return redirect()->route('jabatans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Jabatan());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus jabatan');

        return redirect()->route('jabatans.index');
    }
}
