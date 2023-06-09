<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\IPLType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class IPLTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new IPLType());

        $data ['ipltypes'] = $conn->get();

        return view('AdminSite.IPLType.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.IPLType.create');
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
            $conn = ConnectionDB::setConnection(new IPLType());
            
            DB::beginTransaction();

            $conn->create([
               'id_ipl_type' => $request->id_ipl_type,
                'nama_ipl_type' => $request->nama_ipl_type,
                'biaya_permeter' => $request->biaya_permeter,
                'biaya_procentage' => $request->biaya_procentage,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan IPL type');

            return redirect()->route('ipltypes.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan IPL type');

            return redirect()->route('ipltypes.index');
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
        $conn = ConnectionDB::setConnection(new IPLType());

        $data['ipltype'] = $conn->find($id);

        return view('AdminSite.IPLType.edit', $data);
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
        $conn = ConnectionDB::setConnection(new IPLType());

        $ipltype = $conn->find($id);
        $ipltype->update($request->all());

        if ($request->pilihipl == 1) {
            $ipltype->biaya_permeter = $request->biaya_permeter;
            $ipltype->biaya_procentage = null;
        } else {
            $ipltype->biaya_permeter = null;
            $ipltype->biaya_procentage = $request->biaya_procentage;
        }

        $ipltype->save();

        Alert::success('Berhasil', 'Berhasil mengupdate IPL Type');

        return redirect()->route('ipltypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new IPLType());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus IPL type');

        return redirect()->route('ipltypes.index');
    }
}
