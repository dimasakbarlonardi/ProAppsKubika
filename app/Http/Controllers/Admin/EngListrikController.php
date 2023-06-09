<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\EngListrik;
use Illuminate\Http\Request;

class EngListrikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngListrik());

        $data ['englistriks'] = $conn->get();

        return view('AdminSite.EngListrik.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngListrik.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EngListrik());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_eng_listrik' => $request->id_eng_listrik,
                'nama_eng_listrik' => $request->nama_eng_listrik,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Engeneering Listrik');

            return redirect()->route('englistriks.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering Listrik');

            return redirect()->route('englistriks.index');
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
        $conn = ConnectionDB::setConnection(new EngListrik());

        $data['englistrik'] = $conn->find($id);

        return view('AdminSite.EngListrik.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngListrik());

        $englistrik = $conn->find($id);
        $englistrik->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering Listrik');

        return redirect()->route('englistriks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngListrik());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Engeneering Listrik');

        return redirect()->route('englistriks.index');
    }
}
