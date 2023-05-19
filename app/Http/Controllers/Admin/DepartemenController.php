<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Departemen());
        $data['departemens'] = $conn->get();

        return view('AdminSite.Departemen.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Departemen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Departemen());

        try {
            DB::beginTransaction();

            $conn->create([
                'id_departemen' => $request->id_departemen,
                'nama_departemen' => $request->nama_departemen,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan departemen');

            return redirect()->route('departemens.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan departemen');

            return redirect()->route('departemens.index');
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
        $conn = ConnectionDB::setConnection(new Departemen());

        $data['departemen'] = $conn->find($id);

        return view('AdminSite.Departemen.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Departemen());

        $departemen = $conn->find($id);
        $departemen->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate departemen');

        return redirect()->route('departemens.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Departemen());
        $conn = $conn->find($id);
        $conn->delete();

        Alert::success('Berhasil', 'Berhasil menghapus departemen');

        return redirect()->route('departemens.index');
    }
}
