<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\ConnectionDB;
use App\Models\EngGroundrofftank;
use Illuminate\Http\Request;

class EngGroundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngGroundrofftank());

        $data ['enggrounds'] = $conn->get();

        return view('AdminSite.EngGround.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngGround.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EngGroundrofftank());

        try {
            DB::beginTransaction();

            $conn->create([
                'id_eng_groundrofftank' => $request->id_eng_groundrofftank,
                'nama_eng_groundrofftank' => $request->nama_eng_groundrofftank,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Engeneering Ground Roff Tank');

            return redirect()->route('enggrounds.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering Ground Roff Tank');

            return redirect()->route('enggrounds.index');
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
        $conn = ConnectionDB::setConnection(new EngGroundrofftank());

        $data['engground'] = $conn->find($id);

        return view('AdminSite.EngGround.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngGroundrofftank());

        $engground = $conn->find($id);
        $engground->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering Ground Roff Tank');

        return redirect()->route('enggrounds.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngGroundrofftank());

        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus Engeneering Ground Roff Tank');

        return redirect()->route('enggrounds.index');
    }
}
