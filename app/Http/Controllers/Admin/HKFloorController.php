<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HKFloor;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class HKFloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new HKFloor());

        $data ['hkfloors'] = $conn->get();

        return view('AdminSite.HKFloor.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.HKFloor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new HKFloor());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_hk_floor' => $request->id_hk_floor,
                'nama_hk_floor' => $request->nama_hk_floor,
                'subject' => $request->subject,
                'periode' => $request->periode,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan HK Floor');

            return redirect()->route('hkfloors.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan HK Floor');

            return redirect()->route('hkfloors.index');
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
        $conn = ConnectionDB::setConnection(new HKFloor());

        $data['hkfloor'] = $conn->find($id);

        return view('AdminSite.HKFloor.edit', $data);
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
        
        $conn = ConnectionDB::setConnection(new HKFloor());

        $hkfloor = $conn->find($id);
        $hkfloor->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate HK Floor');

        return redirect()->route('hkfloors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new HKFloor());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus HK Floor');

        return redirect()->route('hkfloors.index');
    }
}
