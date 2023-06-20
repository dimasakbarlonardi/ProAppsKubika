<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantOFF;
use App\Models\TenantUnit;
use App\Models\TenantUnitOFF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OffBoardingTenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function tenantByID($id)
    // {
    //     $conntenant = ConnectionDB::setConnection(new TenantUnit());

    //     $conntenant = $conntenant->where('id_tenant', $id)->get();

    //     return response()->json(['unit' => $conntenant]);
    // }

    public function penjaminByID($id)
    {
        $tenant = ConnectionDB::setConnection(new Tenant());

        $tenant = $tenant->where('id_tenant', $id)->first();

        $nama_unit = [];

        foreach ($tenant->TenantUnit as $unit) {
            $nama_unit[] = $unit->Unit->nama_unit;
        };

        return response()->json([
            'tenant' => $tenant,
            'nama_unit' => $nama_unit
        ]);
    }

    public function index()
    {
        $conntenant = ConnectionDB::setConnection(new Tenant());
        $conn = ConnectionDB::setConnection(new TenantOFF());

        $data['tenants'] = $conntenant->get();
        $data['offtenants'] = $conn->get();

        return view('AdminSite.OffBoardingTenant.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function offdeleteTenantUnit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new Tenant());
        $connTUOFF = ConnectionDB::setConnection(new TenantOFF());

        $nowDate = Carbon::now();

        $conn = $conn->where('id_tenant', $id)->first();
        $conn->delete();

        $connTUOFF->create([
            'id_tenant' => $conn->id_tenant,
            'id_site' => $conn->id_site,
            'id_unit' => $conn->id_unit,
            'tgl_sys' => $nowDate,
            'tgl_masuk' => $conn->created_at,
            'tgl_keluar' => $request->tgl_keluar,
            'keterangan' => $request->keterangan,
        ]);
        DB::commit();

        Alert::success('Berhasil', 'Berhasil menghapus tenant');

        return redirect()->route('offtenants.index');
    }

}