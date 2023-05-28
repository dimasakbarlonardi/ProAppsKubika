<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IdCard;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class IdcardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new IdCard());

        $data['idcards'] = $conn->get();

        return view('AdminSite.IdCard.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.IdCard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new IdCard());

        try {
            DB::beginTransaction();

            $conn->create([
                'card_id_name' => $request->card_id_name,
            ]);


            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan ID Card');

            return redirect()->route('idcards.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan ID Card');

            return redirect()->route('idcards.index');
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
        $conn = ConnectionDB::setConnection(new IdCard());

        $data['idcard'] = $conn->find($id);

        return view('AdminSite.IdCard.edit', $data);
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
        $conn = ConnectionDB::setConnection(new IdCard());

        $idcard = $conn->find($id);
        $idcard->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate ID Card');

        return redirect()->route('idcards.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new IdCard());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus ID Card');

        return redirect()->route('idcards.index');
    }
}
