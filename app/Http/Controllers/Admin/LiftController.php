<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lift;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class LiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Lift());

        $data ['lifts'] = $conn->get();

        return view('AdminSite.Lift.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Lift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Lift());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_hk_lift' => $request->id_hk_lift,
                'nama_hk_lift' => $request->nama_hk_lift,
                'subject' => $request->subject,
                'periode' => $request->periode,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan HK Lift');

            return redirect()->route('lifts.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan HK Lift');

            return redirect()->route('lifts.index');
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
        $conn = ConnectionDB::setConnection(new Lift());

        $data['lift'] = $conn->find($id);

        return view('AdminSite.Lift.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Lift());

        $lift = $conn->find($id);
        $lift->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate HK Lift');

        return redirect()->route('lifts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Lift());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus HK Lift');

        return redirect()->route('lifts.index');
    }
}
