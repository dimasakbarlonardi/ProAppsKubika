<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\StatusTinggal;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class StatusTinggalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new StatusTinggal());
        
        $data['statustinggals'] = $conn->get();

        return view('AdminSite.StatusTinggal.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.StatusTinggal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new StatusTinggal());

        try {
            DB::beginTransaction();
            
            $conn->create($request->all());
            
            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan status tinggal');

            return redirect()->route('statustinggals.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan status tinggal');

            return redirect()->route('statustinggals.index');
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
        $conn = ConnectionDB::setConnection(new StatusTinggal());

        $data['statustinggal'] = $conn->find($id);

        return view('AdminSite.StatusTinggal.edit', $data);
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
        $conn = ConnectionDB::setConnection(new StatusTinggal());

        $statustinggal = $conn->find($id);
        $statustinggal->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate status tinggal');

        return redirect()->route('statustinggals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $conn = ConnectionDB::setConnection(new StatusTinggal());

            $conn->find($id)->delete();

            Alert::success('Berhasil', 'Berhasil menghapus status tinggal');

            return redirect()->route('statustinggals.index');
    }
}
