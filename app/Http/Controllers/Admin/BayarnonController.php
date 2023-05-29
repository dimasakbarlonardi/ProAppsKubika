<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\BayarNon;
use Illuminate\Http\Request;

class BayarnonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new BayarNon());

        $data['bayarnons'] = $conn->get();

        return view('AdminSite.Bayarnon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Bayarnon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new BayarNon());

        try {
            DB::beginTransaction();

            $conn->create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Pembayaran');

            return redirect()->route('bayarnons.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Pembayaran');

            return redirect()->route('bayarnons.index');
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
        $conn = ConnectionDB::setConnection(new BayarNon());

        $data['bayarnon'] = $conn->where('id_bayarnon', $id)->first();

        return view('AdminSite.Bayarnon.edit', $data);
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
        $conn = ConnectionDB::setConnection(new BayarNon());

        $bayarnon = $conn->find($id);

        $bayarnon->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Pembayaran');

        return redirect()->route('bayarnons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new BayarNon());

        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus Pembayaran');

        return redirect()->route('bayarnons.index');
    }
}
