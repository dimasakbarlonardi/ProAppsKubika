<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use App\Models\RuangReservation;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class RuangReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection( new RuangReservation());

        $data['ruangreservations'] = $conn->get();

        return view('AdminSite.RuangReservation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.RuangReservation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new RuangReservation());

        try {
            DB::beginTransaction();

            $conn->create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan ruang reservation');

            return redirect()->route('ruangreservations.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan ruang reservation');

            return redirect()->route('ruangreservations.index');
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
        $conn = ConnectionDB::setConnection(new RuangReservation());

        $data['ruangreservation'] = $conn->where('id_ruang_reservation', $id)->first();

        return view('AdminSite.RuangReservation.edit', $data);
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
        $conn = ConnectionDB::setConnection(new RuangReservation());

        $jenisrequest = $conn->find($id);
        $jenisrequest->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate ruang reservation');

        return redirect()->route('ruangreservations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new RuangReservation());

        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus ruangan reservation');

        return redirect()->route('ruangreservations.index');
    }
}
