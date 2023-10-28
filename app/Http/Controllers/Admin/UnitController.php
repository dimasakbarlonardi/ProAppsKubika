<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Site;
use App\Models\Login;
use App\Models\Tower;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Unit;
use App\Models\Floor;
use App\Models\Hunian;
use App\Models\TenantUnit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $connTower = ConnectionDB::setConnection(new Tower());
        $connFloor = ConnectionDB::setConnection(new Floor());

        $data['floors'] = $connFloor->get();
        $data['towers'] = $connTower->get();

        return view('AdminSite.Unit.index', $data);
    }

    public function unitsByFilter(Request $request)
    {
        $connUnit = ConnectionDB::setConnection(new Unit());

        $data['units'] = $connUnit
            ->where('id_lantai', $request->id_floor)
            ->where('id_tower', $request->id_tower)
            ->get();

        return response()->json([
            'html' => view('AdminSite.Unit.card', $data)->render(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Unit());
        $connTower = ConnectionDB::setConnection(new Tower());
        $connFloor = ConnectionDB::setConnection(new Floor());
        $connHunias = ConnectionDB::setConnection(new Hunian());

        $data['towers'] = $connTower->get();
        $data['floors'] = $connFloor->get();
        $data['units'] = $conn->get();
        $data['hunians'] = $connHunias->get();

        return view('AdminSite.Unit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Unit());

        try {
            DB::beginTransaction();

            $user_id = $request->user()->id;
            $login = Login::where('id', $user_id)->with('site')->first();
            $tower = ConnectionDB::setConnection(new Tower());
            $site = $login->site->id_site;
            $tower = $tower->where('id_site', $site)->first();

            $floor = ConnectionDB::setConnection(new Floor());

            $count = $conn->count();
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            };

            $id_unit = $site . $tower->id_tower . $floor->id_lantai . $count;

            $conn->create([
                'id_unit' => $id_unit,
                'id_site' => $site,
                'id_tower' => $request->id_tower,
                'id_lantai' => $request->id_lantai,
                'id_hunian' => $request->id_hunian,
                'barcode_unit' => $request->barcode_unit,
                'nama_unit' => $request->nama_unit,
                'luas_unit' => $request->luas_unit,
                'barcode_meter_air' => $request->barcode_meter_air,
                'barcode_meter_gas' => $request->barcode_meter_gas,
                'barcode_meter_listrik' => $request->barcode_meter_listrik,
                'no_meter_air' => $request->no_meter_air,
                'no_meter_listrik' => $request->no_meter_air,
                'no_meter_gas' => $request->no_meter_air,
                'meter_air_awal' => $request->meter_air_awal,
                'meter_air_akhir' => $request->meter_air_akhir,
                'meter_listrik_awal' => $request->meter_listrik_awal,
                'meter_listrik_akhir' => $request->meter_listrik_akhir,
                'meter_gas_awal' => $request->meter_gas_awal,
                'meter_gas_akhir' => $request->meter_gas_akhir,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan unit');

            return redirect()->route('units.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan unit');

            return redirect()->route('units.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new Unit());

        $unit = $conn->where('id_unit', $id)->first();
        $data['units'] = $unit;

        return view('AdminSite.Unit.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new Unit());
        $connTower = ConnectionDB::setConnection(new Tower());
        $connFloor = ConnectionDB::setConnection(new Floor());
        $connHunias = ConnectionDB::setConnection(new Hunian());

        $data['unit'] = $conn->where('id_unit', $id)->first();
        $data['towers'] = $connTower->get();
        $data['floors'] = $connFloor->get();
        $data['hunians'] = $connHunias->get();


        return view('AdminSite.Unit.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Unit());

        $unit = $conn->find($id);
        $unit->GenerateBarcode();
        $unit->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate unit');

        return redirect()->route('units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $conn = $this->setConnection($request);
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus unit');

        return redirect()->route('units.index');
    }

    public function UnitByTenant($id)
    {
        $connTenantUnit = ConnectionDB::setConnection(new TenantUnit());

        $tenantUnit = $connTenantUnit->where('id_tenant', $id)
            ->with(['unit'])
            ->get();

        return response()->json(['data' => $tenantUnit]);
    }
}
