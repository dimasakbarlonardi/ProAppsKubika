<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerhitDenda;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\ConnectionDB;
use Illuminate\Http\Request;

class PerhitDendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new PerhitDenda());

        $data ['perhitdendas'] = $conn->get();

        return view('AdminSite.PerhitDenda.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.PerhitDenda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new PerhitDenda());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_perhit_denda' => $request->id_perhit_denda,
                'jenis_denda' => $request->jenis_denda,
                'denda_flat_procetage' => $request->denda_flat_procetage,
                'denda_flat_amount' => $request->denda_flat_amount,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Perhitungan Denda');

            return redirect()->route('perhitdendas.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Perhitungan Denda');

            return redirect()->route('perhitdendas.index');
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
        $conn = ConnectionDB::setConnection(new PerhitDenda());

        $data['perhitdenda'] = $conn->find($id);

        return view('AdminSite.PerhitDenda.edit', $data);
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
        $conn = ConnectionDB::setConnection(new PerhitDenda());

        $perhitdenda = $conn->find($id);
        $perhitdenda->update($request->all());

        if ($request->pilihipl == 1) {
            $perhitdenda->denda_flat_procetage = $request->denda_flat_procetage;
            $perhitdenda->denda_flat_amount = null;
        } else {
            $perhitdenda->denda_flat_procetage = null;
            $perhitdenda->denda_flat_amount = $request->denda_flat_amount;
        }

        $perhitdenda->save();

        Alert::success('Berhasil', 'Berhasil mengupdate Perhitungan Denda');

        return redirect()->route('perhitdendas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new PerhitDenda());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Perhitungan Denda');

        return redirect()->route('perhitdendas.index');
    }
}
