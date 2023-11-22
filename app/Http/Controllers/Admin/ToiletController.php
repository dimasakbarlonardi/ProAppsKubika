<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toilet;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
//  public function deleteTenantUnit(Request $request, $id)
//     {
//         $conn = $this->setConnection(new TenantUnit());
//         $connTUOFF = ConnectionDB::setConnection(new TenantUnitOFF());

//         $nowDate = Carbon::now();

//         $conn = $conn->where('id_tenant_unit', $id)->first();
//         $conn->unit->isempty = 1;
//         $conn->unit->save();
//         $conn->delete();

//         $connTUOFF->create([
//             'id_tenant' => $conn->id_tenant,
//             'id_unit' => $conn->id_unit,
//             'id_pemilik' => $conn->id_pemilik,
//             'tgl_masuk' => $conn->tgl_masuk,
//             'tgl_keluar' => $conn->tgl_keluar,
//             'tgl_sys' => $nowDate,
//             'keterangan' => $request->keterangan,
//             'sewa_ke' => 2
//         ]);

//         Alert::success('Berhasil', 'Berhasil menghapus tenant unit');

//         return redirect()->route('getTenantUnit', $id);
//     }

class ToiletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Toilet());

        $data ['housekeeping'] = $conn->get();

        return view('AdminSite.Toilet.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Toilet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Toilet());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_hk_toilet' => $request->id_hk_toilet,
                'nama_hk_toilet' => $request->nama_hk_toilet,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan HK Toilet');

            return redirect()->route('housekeeping.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan HK Toilet');

            return redirect()->route('housekeeping.index');
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
        $conn = ConnectionDB::setConnection(new Toilet());

        $data['toilet'] = $conn->find($id);

        return view('AdminSite.Toilet.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Toilet());

        $toilet = $conn->find($id);
        $toilet->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate HK Toilet');

        return redirect()->route('housekeeping.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Toilet());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus HK Toilet');

        return redirect()->route('housekeeping.index');
    }
}
