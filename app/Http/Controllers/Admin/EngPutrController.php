<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\EngPutr;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EngPutrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngPutr());

        $data ['engputrs'] = $conn->get();

        return view('AdminSite.EngPutr.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngPutr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EngPutr());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_eng_putr' => $request->id_eng_putr,
                'nama_eng_putr' => $request->nama_eng_putr,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Engeneering Putr');

            return redirect()->route('engputrs.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering Putr');

            return redirect()->route('engputrs.index');
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
        $conn = ConnectionDB::setConnection(new EngPutr());

        $data['engputr'] = $conn->find($id);

        return view('AdminSite.EngPutr.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngPutr());

        $engputr = $conn->find($id);
        $engputr->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering Putr');

        return redirect()->route('engputrs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngPutr());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Engeneering Putr');

        return redirect()->route('engputrs.index');
    }
}
