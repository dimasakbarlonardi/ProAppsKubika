<?php

namespace App\Http\Controllers\Admin;

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


class UnitController extends Controller
{
     public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new Unit();
        $user->setConnection($conn);

        return $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = $this->setConnection($request);
        $data['units'] = $conn->get();
        return view('AdminSite.Unit.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $tower = new Tower();
        $tower->setConnection($conn);

        $floor = new Floor();
        $floor->setConnection($conn);

        $hunian = new Hunian();
        $hunian->setConnection($conn);

        $total_unit = $this->setConnection($request);
        $total_unit = $total_unit->count();
        $data['current_id'] = $total_unit;

        $data['towers'] = $tower->where('id_site', $login->id_site)->get();
        $data['floors'] = $floor->get();
        $data['hunians'] = $hunian->get();

        return view ('AdminSite.Unit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = $this->setConnection($request);

        try {
            DB::beginTransaction();

            $user_id = $request->user()->id;
            $login = Login::where('id', $user_id)->with('site')->first();
            $tower = new Tower();
            $tower = $tower->setConnection($login->site->db_name);
            $site = $login->site->id_site;
            $tower = $tower->where('id_site', $site)->first();

            $floor = new Floor();
            $floor = $floor->setConnection($conn);


            $count = $conn->count();
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            }

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
    public function edit(Request $request, $id)
    {
        $conn = $this->setConnection($request);

        $data['unit'] = $conn->where('id_unit',$id)->first();

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
        $conn = $this->setConnection($request);

        $unit = $conn->find($id);
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
}
