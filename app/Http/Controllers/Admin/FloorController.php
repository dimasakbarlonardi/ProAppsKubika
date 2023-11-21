<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\Login;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Floor());

        $data['floors'] = $conn->orderBy('created_at', 'ASC')->get();

        return view('AdminSite.Floor.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Floor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Floor());

        try {
            DB::beginTransaction();

            $conn->create([
                'id_lantai' => rand(100, 200),
                'nama_lantai' => $request->nama_lantai,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Lantai');

            return redirect()->route('floors.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan lantai');

            return redirect()->route('floors.index');
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
        $conn = ConnectionDB::setConnection(new Floor());

        $data['floor'] = $conn->find($id);

        return view('AdminSite.Floor.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Floor());

        $floor = $conn->find($id);
        $floor->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate lantai');

        return redirect()->route('floors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $conn = ConnectionDB::setConnection(new Floor());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus lantai');

        return redirect()->route('floors.index');
    }
}
