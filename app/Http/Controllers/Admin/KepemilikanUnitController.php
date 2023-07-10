<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\KepemilikanUnit;
use App\Models\KepemilikanUnitOff;
use App\Models\Login;
use App\Models\OwnerH;
use App\Models\StatusHunianTenant;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class KepemilikanUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $connKepemilikan = ConnectionDB::setConnection(new KepemilikanUnit());
        $data['kepemilikans'] = $connKepemilikan->get();

        return view('AdminSite.KepemilikanUnit.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connStatushunian = ConnectionDB::setConnection(new StatusHunianTenant());

        $data['owners'] = $connOwner->get();
        $data['statushunians'] = $connStatushunian->get();

        return view('AdminSite.KepemilikanUnit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $connKepemilikan = ConnectionDB::setConnection(new KepemilikanUnit());
        $connUnit = ConnectionDB::setConnection(new Unit());

        try {

            DB::beginTransaction();

            $connKepemilikan->create([
                'id_pemilik' => $request->id_pemilik,
                'id_unit' => $request->id_unit,
                'id_status_hunian' => $request->id_status_hunian,
                'tgl_mulai' => $request->tgl_mulai,
                'no_bukti_milik' => $request->no_bukti_milik,
                'keterangan' => $request->keterangan,
            ]);

            $unit = $connUnit->find($request->id_unit);
            $unit->update($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan kepemilikan unit');

            return redirect()->route('kepemilikans.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan kepemilikan unit');

            return redirect()->route('kepemilikans.index');
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
        $conn = ConnectionDB::setConnection(new KepemilikanUnit());
        $connowner = ConnectionDB::setConnection(new OwnerH());
        $connunit = ConnectionDB::setConnection(new Unit());

        $data['kepemilikans'] = $conn->where('id_pemilik', $id)->first();
        $data['owners'] = $connowner->get();
        $data['units'] = $connunit->get();


        return view('AdminSite.KepemilikanUnit.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $conn = ConnectionDB::setConnection(new KepemilikanUnit());
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connStatushunian = ConnectionDB::setConnection(new StatusHunianTenant());

        $data['kepemilikans'] = $conn->where('id_kepemilikan_unit', $id)->get();
        $data['owners'] = $connOwner->get();
        $data['units'] = $connUnit->get();
        $data['statushunians'] = $connStatushunian->get();

        return view('AdminSite.KepemilikanUnit.edit', $data);
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
        $connKepemilikan = ConnectionDB::setConnection(new KepemilikanUnit());


        $kepemilikan = $connKepemilikan->find($id);
        $kepemilikan->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate kepemilikan unit');

        return redirect()->route('kepemilikans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new KepemilikanUnit());
        $conKUOFF = ConnectionDB::setConnection(new KepemilikanUnitOff());

        $nowDate = Carbon::now();

        $conn = $conn->where('id', $id)->first();
        $conn->unit->isempty = 0;
        $conn->unit->save();
        $conn->delete();

        $conKUOFF->create([
            'id_pemilik' => $conn->id_pemilik,
            'id_unit' => $conn->id_unit,
            'id_status_hunian' => $conn->id_status_hunian,
            'tgl_masuk' => $conn->created_at,
            'tgl_keluar' => $nowDate,
            'tgl_sys' => $nowDate,
            'no_bukti_milik' => $conn->no_bukti_milik,
            'keterangan' => $request->keterangan,
        ]);
        DB::commit();

        Alert::success('Berhasil', 'Berhasil menghapus kepemilikan unit');

        return redirect()->route('kepemilikans.index');
    }

    public function notKepemilikanUnit($id)
    {
        $connKepemilikanUnit = ConnectionDB::setConnection(new KepemilikanUnit());
        $connUnit = ConnectionDB::setConnection(new Unit());

        $kepemilikanUnit = $connKepemilikanUnit->where('id_pemilik', $id)->get();
        $units = [];
        foreach ($kepemilikanUnit as $unit) {
            $units[] += $unit->id_unit;
        }
        $getUnits = $connUnit->whereNotIn('id_unit', $units)->get();

        return response()->json([
            'units' => $getUnits
        ]);
    }

    public function unitByID($id)
    {
        $connUnit = ConnectionDB::setConnection(new Unit());

        $unit = $connUnit->find($id);

        return response()->json(['unit' => $unit]);
    }

    public function unitdetail(Request $request, $id)
    {
        $connUnit = ConnectionDB::setConnection(new Unit());

        if ($request->no_checklist_toilet) {
            $data = $connUnit->where('id_unit', $request->id_unit);
        }
        $data = $data->get();

        return response()->json(['unit' => $data]);
    }
}
