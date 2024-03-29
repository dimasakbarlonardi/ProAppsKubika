<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Divisi());
        $data['divisis'] = $conn->get();

        return view('AdminSite.Divisi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Divisi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Divisi());

        try {
            DB::beginTransaction();

            $conn->create([
                'id_divisi' => $request->id_divisi,
                'nama_divisi' => $request->nama_divisi,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan divisi');

            return redirect()->route('divisis.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan divisi');

            return redirect()->route('divisis.index');
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
        $conn = ConnectionDB::setConnection(new Divisi());

        $data['divisi'] = $conn->find($id);

        return view('AdminSite.Divisi.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Divisi());

        $divisi = $conn->find($id);
        $divisi->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate divisi');

        return redirect()->route('divisis.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Divisi());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus divisi');

        return redirect()->route('divisis.index');
    }
}
