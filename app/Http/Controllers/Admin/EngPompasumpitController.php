<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EngPompasumpit;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class EngPompasumpitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngPompasumpit());

        $data ['engpompas'] = $conn->get();

        return view('AdminSite.EngPompaSumpit.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngPompaSumpit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EngPompasumpit());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_eng_pompasumpit' => $request->id_eng_pompasumpit,
                'nama_eng_pompasumpit' => $request->nama_eng_pompasumpit,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Engeneering PompaSumpit');

            return redirect()->route('engpompas.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering PompaSumpit');

            return redirect()->route('engpompas.index');
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
        $conn = ConnectionDB::setConnection(new EngPompasumpit());

        $data['engpompa'] = $conn->find($id);

        return view('AdminSite.EngPompaSumpit.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngPompasumpit());

        $engpompa = $conn->find($id);
        $engpompa->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering PompasSumpit');

        return redirect()->route('engpompas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngPompasumpit());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Engeneering PompasSumpit');

        return redirect()->route('engpams.index');
    }
}
