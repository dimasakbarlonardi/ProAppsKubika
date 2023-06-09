<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\EngDeepWheel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EngDeepWheelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngDeepWheel());
        $data['engdeeps'] = $conn->get();

        return view('AdminSite.EngDeepWheel.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngDeepWheel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        try {
            $conn = ConnectionDB::setConnection(new EngDeepWheel());

            DB::beginTransaction();
            
            $conn->create([
                'id_eng_deep' => $request->id_eng_deep,
                'nama_eng_deep' => $request->nama_eng_deep,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil Menambahkan Engeneering DeepWheel');

            return redirect()->route('engdeeps.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering DeepWheel');

            return redirect()->route('engdeeps.index');
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
        $conn = ConnectionDB::setConnection(new EngDeepWheel());

        $data['engdeep'] = $conn->find($id);

        return view('AdminSite.EngDeepWheel.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngDeepWheel());

        $engdeep = $conn->find($id);
        $engdeep->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering DeepWheel');

        return redirect()->route('engdeeps.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngDeepWheel());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Engeneering DeepWheel');

        return redirect()->route('engdeeps.index');
    }
}
