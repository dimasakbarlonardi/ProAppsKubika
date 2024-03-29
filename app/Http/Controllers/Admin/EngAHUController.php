<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Imports\EngineeringParameter;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\EngAhu;
use Illuminate\Http\Request;
use Excel;

class EngAHUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngAhu());

        $data ['engahus'] = $conn->paginate(10);

        return view('AdminSite.EngAhu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngAhu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EngAhu());

        try {

            DB::beginTransaction();

            $conn->create([
                'id_eng_ahu' => $request->id_eng_ahu,
                'nama_eng_ahu' => $request->nama_eng_ahu,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Success', 'Successfully Added Inspection Engeneering Parameter');
            return redirect()->route('engineering.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering AHU');

            return redirect()->route('engineering.index');
        }
    }

    public function import(Request $request)
    {
        $file = $request->file('file_excel');

        Excel::import(new EngineeringParameter(), $file);

        Alert::success('Success', 'Success import data');

        return redirect()->route('engahus.index');
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
        $conn = ConnectionDB::setConnection(new EngAhu());

        $data['engahu'] = $conn->find($id);

        return view('AdminSite.EngAhu.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngAhu());

        $checklistahu = $conn->find($id);
        $checklistahu->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering AHU');

        return redirect()->route('engineering.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngAhu());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Engeneering AHU');

        return redirect()->route('engineering.index');
    }
}
