<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Utility;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UtilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Utility());

        $data ['utilitys'] = $conn->get();

        return view('AdminSite.Utility.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Utility.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Utility());

        try {
            DB::beginTransaction();

            $conn->create([
                'id_utility' => $request->id_utility,
                'nama_utility' => $request->nama_utility,
                'biaya_admin'=> $request->biaya_admin,
                'biaya_abodemen'=> $request->biaya_abodemen,
                'biaya_tetap'=> $request->biaya_tetap,
                'biaya_m3'=> $request->biaya_m3,
                'biaya_pju'=> $request->biaya_pju,
                'biaya_ppj'=> $request->biaya_ppj,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Utility');

            return redirect()->route('utilitys.index');
        } catch (\Throwable $e) {
            DB::roolback();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Utility');

            return redirect()->route('utilitys.index');
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
        $conn = ConnectionDB::setConnection(new Utility());

        $data['utility'] = $conn->find($id);

        return view('AdminSite.Utility.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Utility());

        $utility = $conn->find($id);
        $utility->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Utility');

        return redirect()->route('utilitys.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Utility());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Utility');

        return redirect()->route('utilitys.index');
    }
}
