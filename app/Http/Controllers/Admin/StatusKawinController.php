<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\StatusKawin;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class StatusKawinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new StatusKawin());

        $data['statuskawins'] = $conn->get();

        return view('AdminSite.StatusKawin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.StatusKawin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new StatusKawin());

        try {
            DB::beginTransaction();

            $conn->create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan status kawin');

            return redirect()->route('statuskawins.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan status kawin');

            return redirect()->route('statuskawins.index');
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
    public function edit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new StatusKawin());

        $data['statuskawin'] = $conn->where('id_status_kawin',$id)->first();

        return view('AdminSite.StatusKawin.edit', $data);
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
        $conn = ConnectionDB::setConnection(new StatusKawin());

        $statuskawin = $conn->find($id);

        $statuskawin->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate status kawin');

        return redirect()->route('statuskawins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        $conn = ConnectionDB::setConnection(new StatusKawin());

        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus status kawin');

        return redirect()->route('statuskawins.index');
    }
}
