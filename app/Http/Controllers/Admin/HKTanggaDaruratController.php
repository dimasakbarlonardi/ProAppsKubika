<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Helpers\ConnectionDB;
use App\Models\HKTanggaDarurat;
USE RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class HKTanggaDaruratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new HKTanggaDarurat());

        $data ['hktanggadarurats'] = $conn->get();

        return view('AdminSite.HKTanggaDarurat.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.HKTanggaDarurat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new HKTanggaDarurat());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_hk_tangga_darurat' => $request->id_hk_tangg_darurat,
                'nama_hk_tangga_darurat' => $request->nama_hk_tangga_darurat,
                'subject' => $request->subject,
                'periode' => $request->periode,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan HK Tangga Darurat');

            return redirect()->route('hktanggadarurats.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan HK Tangga Darurat');

            return redirect()->route('hktanggadarurats.index');
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
        $conn = ConnectionDB::setConnection(new HKTanggaDarurat());

        $data['tanggadarurat'] = $conn->find($id);

        return view('AdminSite.HKTanggaDarurat.edit', $data);
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
        $conn = ConnectionDB::setConnection(new HKTanggaDarurat());

        $hktanggadarurat = $conn->find($id);
        $hktanggadarurat->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate HK Tangga Darurat');

        return redirect()->route('hktanggadarurats.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new HKTanggaDarurat());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus HK Tangga Darurat');

        return redirect()->route('hktanggadarurats.index');
    }
}
