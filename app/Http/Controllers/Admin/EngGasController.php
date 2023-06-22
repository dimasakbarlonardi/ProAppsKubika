<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EngGas;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class EngGasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngGas());

        $data ['enggases'] = $conn->get();

        return view('AdminSite.EngGas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngGas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EngGas());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_eng_gas' => $request->id_eng_gas,
                'nama_eng_gas' => $request->nama_eng_gas,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Engeneering Gas');

            return redirect()->route('enggases.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering Gas');

            return redirect()->route('enggases.index');
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
        $conn = ConnectionDB::setConnection(new EngGas());

        $data['enggas'] = $conn->find($id);

        return view('AdminSite.EngGas.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngGas());

        $enggas = $conn->find($id);
        $enggas->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering Gas');

        return redirect()->route('enggases.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngGas());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Engeneering Gas');

        return redirect()->route('enggases.index');
    }
}
