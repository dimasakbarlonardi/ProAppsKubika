<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\JenisKendaraan;
use Illuminate\Http\Request;

class JenisKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new JenisKendaraan());
        $data['jeniskendaraans'] = $conn->get();

        return view('AdminSite.JenisKendaraan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.JenisKendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new JenisKendaraan());

        try {
            $conn->create([
                'jenis_kendaraan' => $request->jenis_kendaraan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan jenis kendaraan');

            return redirect()->route('jeniskendaraans.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan jenis kendaraan');

            return redirect()->route('jeniskendaraans.index');
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
        $conn = ConnectionDB::setConnection(new JenisKendaraan());

        $data['jeniskendaraan'] = $conn->find($id);

        return view('AdminSite.JenisKendaraan.edit', $data);
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
        $conn = ConnectionDB::setConnection(new JenisKendaraan());

        $jeniskendaraan = $conn->find($id);
        $jeniskendaraan->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate jenis kendaraan');

        return redirect()->route('jeniskendaraans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new JenisKendaraan());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus jenis kendaraan');

        return redirect()->route('jeniskendaraans.index');
    }
}
