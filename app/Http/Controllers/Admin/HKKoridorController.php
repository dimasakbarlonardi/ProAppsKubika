<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HKKoridor;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class HKKoridorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new HKKoridor());

        $data ['hkkoridors'] = $conn->get();

        return view('AdminSite.HKKoridor.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.HKKoridor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new HKKoridor());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_hk_koridor' => $request->id_hk_koridor,
                'nama_hk_koridor' => $request->nama_hk_koridor,
                'subject' => $request->subject,
                'periode' => $request->periode,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan HK Koridor');

            return redirect()->route('hkkoridors.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan HK Koridor');

            return redirect()->route('hkkoridors.index');
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
        $conn = ConnectionDB::setConnection(new HKKoridor());

        $data['hkkoridor'] = $conn->find($id);

        return view('AdminSite.HKKoridor.edit', $data);
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
          
        $conn = ConnectionDB::setConnection(new HKKoridor());

        $hkkoridor = $conn->find($id);
        $hkkoridor->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate HK Koridor');

        return redirect()->route('hkkoridors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new HKKoridor());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus HK Koridor');

        return redirect()->route('hkkoridors.index');
    }
}
