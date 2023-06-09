<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisDenda;
use App\Helpers\ConnectionDB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class JenisDendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new JenisDenda());

        $data ['jenisdendas'] = $conn->get();

        return view('AdminSite.JenisDenda.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.JenisDenda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        try {
            $conn = ConnectionDB::setConnection(new JenisDenda());
            
            DB::beginTransaction();
    
            $conn->create([
                'id_jenis_denda' => $request->id_jenis_denda,
                'jenis_denda' => $request->jenis_denda,
                'denda_flat_procetage' => $request->denda_flat_procetage,
                'denda_flat_amount' => $request->denda_flat_amount,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Jenis Denda');

            return redirect()->route('jenisdendas.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Jenis Denda');

            return redirect()->route('jenisdendas.index');
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
        $conn = ConnectionDB::setConnection(new JenisDenda());

        $data['jenisdenda'] = $conn->find($id);

        return view('AdminSite.JenisDenda.edit', $data);
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
        $conn = ConnectionDB::setConnection(new JenisDenda());

        $jenisdenda = $conn->find($id);
        $jenisdenda->update($request->all());

        if ($request->pilihipl == 1) {
            $jenisdenda->denda_flat_procetage = $request->denda_flat_procetage;
            $jenisdenda->denda_flat_amount = null;
        } else {
            $jenisdenda->denda_flat_procetage = null;
            $jenisdenda->denda_flat_amount = $request->denda_flat_amount;
        }

        $jenisdenda->save();

        Alert::success('Berhasil', 'Berhasil mengupdate Jenis Denda');

        return redirect()->route('jenisdendas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new JenisDenda());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Jenis Denda');

        return redirect()->route('jenisdendas.index');
    }
}
