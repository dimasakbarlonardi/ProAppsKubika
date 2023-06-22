<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\EngPemadam;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class EngPemadamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngPemadam());

        $data ['engpemadams'] = $conn->get();

        return view('AdminSite.EngPemadam.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngPemadam.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EngPemadam());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_eng_pemadam' => $request->id_eng_pemadam,
                'nama_eng_pemadam' => $request->nama_eng_pemadam,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Engeneering Pemadam');

            return redirect()->route('engpemadams.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering Pemadam');

            return redirect()->route('engpemadams.index');
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
        $conn = ConnectionDB::setConnection(new EngPemadam());

        $data['engpemadam'] = $conn->find($id);

        return view('AdminSite.EngPemadam.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngPemadam());

        $engpemadam = $conn->find($id);
        $engpemadam->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering Pemadam');

        return redirect()->route('engpemadams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngPemadam());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Engeneering Pemadam');

        return redirect()->route('engpemadams.index');
    }
}
