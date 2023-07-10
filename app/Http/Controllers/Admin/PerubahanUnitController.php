<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\KepemilikanUnit;
use App\Models\KepemilikanUnitOff;
use App\Models\Login;
use App\Models\OwnerH;
use App\Models\PeriodeSewa;
use App\Models\StatusHunianTenant;
use App\Models\Tenant;
use App\Models\TenantUnit;
use App\Models\TenantUnitOFF;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PerubahanUnitController extends Controller
{

    public function setConnection($model)
    {
        $request = Request();
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;

        $model = $model;
        $model->setConnection($conn);

        return $model;
    }

    public function getUnitIDFromTU()
    {
        $tenant_units = $this->setConnection(new TenantUnit());
        $tenant_units = $tenant_units->get();
        $idUnit = [];

        foreach ($tenant_units as $unit) {
            $idUnit[] = $unit->id_unit;
        }

        $units = $this->setConnection(new Unit());
        $units = $units->whereNotIn('id_unit', $idUnit)->get();

        return $units;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new TenantUnit());
        $connkepemilikan = ConnectionDB::setConnection(new KepemilikanUnit());

        $data['tenant_units'] = $conn->get();
        $data['kepemilikans'] = $connkepemilikan->get();

        return view('AdminSite.PerubahanUnit.index', $data);
    }


    // public function editPerubahanTU($id)
    // {
    //     $connTenantUnit = $this->setConnection(new TenantUnit());
    //     $connUnit = $this->setConnection(new Unit());
    //     $periodeSewa = $this->setConnection(new PeriodeSewa());
    //     $connOwner = $this->setConnection(new OwnerH());

    //     $data['id_tenant'] = $id;
    //     $data['units'] = $connUnit->get();
    //     $data['owners'] = $connOwner->get();
    //     $data['periodeSewa'] = $periodeSewa->get();
    //     $data['tenantunit'] = $connTenantUnit->where('id_tenant_unit', $id)->first();
    //     $data['getCreateUnits'] = $this->getUnitIDFromTU();

    //     return view('AdminSite.PerubahanUnit.Perpanjang.edit', $data)->render();
    // }

    public function updateTenantUnit(Request $request, $id)
    {
        $connTenantUnit = $this->setConnection(new TenantUnit());
        $connTUOFF = ConnectionDB::setConnection(new TenantUnitOFF());


        $tu = $connTenantUnit->where('id_tenant_unit', $id)->first();

        $createOff = $connTUOFF;
        $createOff->id_pemilik = $tu->id_pemilik;
        $createOff->id_tenant = $tu->id_tenant;
        $createOff->id_unit = $tu->id_unit;
        $createOff->id_periode_sewa = $request->id_periode_sewa;
        $createOff->tgl_masuk = $tu->tgl_masuk;
        $createOff->tgl_keluar = $tu->tgl_keluar;
        $createOff->sewa_ke = $tu->sewa_ke;
        $createOff->keterangan = 'perpanjangan sewa unit';
        $createOff->save();

        $tu->id_periode_sewa = $request->id_periode_sewa;
        $tu->tgl_masuk = $request->tgl_masuk;
        $tu->tgl_keluar = $request->tgl_keluar;
        $tu->sewa_ke = $tu->sewa_ke + 1;

        $tu->save();

        DB::commit();

        Alert::success('Berhasil', 'Berhasil Perpanjang Sewa Unit');

        return redirect()->route('perubahanunits.index');
    }

    public function updatePerubahanUnit(Request $request, $id)
    {
        $connTenantUnit = $this->setConnection(new TenantUnit());
        $connTUOFF = ConnectionDB::setConnection(new TenantUnitOFF());


        $tu = $connTenantUnit->where('id_tenant_unit', $id)->first();

        $createOff = $connTUOFF;
        $createOff->id_pemilik = $tu->id_pemilik;
        $createOff->id_tenant = $tu->id_tenant;
        $createOff->id_unit = $tu->id_unit;
        $createOff->id_periode_sewa = $request->id_periode_sewa;
        $createOff->tgl_masuk = $tu->tgl_masuk;
        $createOff->tgl_keluar = $tu->tgl_keluar;
        $createOff->sewa_ke = $tu->sewa_ke;
        $createOff->keterangan = 'perubahan unit';
        $createOff->save();

        // $tu->id_periode_sewa = $request->id_periode_sewa;
        // $tu->tgl_masuk = $request->tgl_masuk;
        // $tu->tgl_keluar = $request->tgl_keluar;
        // $tu->sewa_ke = $tu->sewa_ke + $countOff;

        $tu->id_unit = $request->id_unit;
        

        $tu->save();

        DB::commit();

        Alert::success('Berhasil', 'Berhasil Perubahan Unit');

        return redirect()->route('perubahanunits.index');
    }

    public function updateKU(Request $request, $id)
    {
        $connKepemilikan = ConnectionDB::setConnection(new KepemilikanUnit());
        $connKUOFF = ConnectionDB::setConnection(new KepemilikanUnitOff());


        $tu = $connKepemilikan->where('id_pemilik', $id)->first();
         
        $createOff = $connKUOFF;
        $createOff->id_pemilik = $tu->id_pemilik;
        $createOff->id_unit = $tu->id_unit;
        $createOff->id_status_hunian = $tu->id_status_hunian;
        $createOff->tgl_masuk = $tu->created_at;
        $createOff->tgl_keluar = $tu->updated_at;
        $createOff->no_bukti_milik = $tu->no_bukti_milik;
        $createOff->keterangan = 'Perpindahan Kepemilikan unit';
        $createOff->save();

        $tu->id_pemilik = $request->id_pemilik;
        $tu->id_unit = $request->id_unit;
        $tu->id_status_hunian = $request->id_status_hunian;
        $tu->tgl_mulai = $tu->tgl_mulai;
        $tu->no_bukti_milik = $tu->no_bukti_milik;
        $tu->keterangan = $tu->keterangan;

        $tu->save();

        DB::commit();

        Alert::success('Berhasil', 'Berhasil Pindah Kepemilikan Unit');

        return redirect()->route('perubahanunits.index');
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
        $conn = ConnectionDB::setConnection(new TenantUnit());
        $connTenantUnit = $this->setConnection(new TenantUnit());

        $data['tenantunits'] = $conn->where('id_tenant_unit', $id)->first();
        $data['editTenantUnit'] = $connTenantUnit->where('id_tenant_unit', $id)->first();

        return view('AdminSite.PerubahanUnit.Perpanjang.show', $data);
    }

    public function showKU($id)
    {
        $conn = ConnectionDB::setConnection(new KepemilikanUnit());
        $connKepemilikanUnit = $this->setConnection(new KepemilikanUnit());

        $data['kepemilikans'] = $conn->where('id', $id)->first();
        $data['editkepemilikanunit'] = $connKepemilikanUnit->where('id_pemilik', $id)->first();

        return view('AdminSite.PerubahanUnit.PindahKepemilikan.table', $data);
    }

    public function showTPU($id)
    {
        $conn = ConnectionDB::setConnection(new TenantUnit());
        $connTenantUnit = $this->setConnection(new TenantUnit());

        $data['tenantunits'] = $conn->where('id_tenant_unit', $id)->first();
        $data['editTenantUnit'] = $connTenantUnit->where('id_tenant_unit', $id)->first();

        return view('AdminSite.PerubahanUnit.TidakPerpanjangUnit.table', $data);
    }

    public function showPerubahan($id)
    {
        $conn = ConnectionDB::setConnection(new TenantUnit());
        $connTenantUnit = $this->setConnection(new TenantUnit());

        $data['tenantunits'] = $conn->where('id_tenant_unit', $id)->first();
        $data['editTenantUnit'] = $connTenantUnit->where('id_tenant_unit', $id)->first();

        return view('AdminSite.PerubahanUnit.Perubahan.table', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $connTenantUnit = ConnectionDB::setConnection(new TenantUnit());
        $connUnit = $this->setConnection(new Unit());
        $periodeSewa = $this->setConnection(new PeriodeSewa());
        $connOwner = $this->setConnection(new OwnerH());

        $data['tenantunit'] = $connTenantUnit->where('id_tenant_unit', $id)->first();
        // $data['tenantunit'] = $connTenantUnit->find($id);
        $data['id_tenant'] = $id;
        $data['units'] = $connUnit->get();
        $data['owners'] = $connOwner->get();
        $data['periodeSewa'] = $periodeSewa->get();
        $data['getCreateUnits'] = $this->getUnitIDFromTU();

        return view('AdminSite.PerubahanUnit.Perpanjang.edit', $data);
    }

    public function editKU($id)
    {
        $conn = ConnectionDB::setConnection(new KepemilikanUnit());
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connStatushunian = ConnectionDB::setConnection(new StatusHunianTenant());

        $data['kepemilikans'] = $conn->where('id_pemilik', $id)->first();
        // $data['kepemilikans'] = $conn->find($id);
        $data['owners'] = $connOwner->get();
        $data['units'] = $connUnit->get();
        $data['statushunians'] = $connStatushunian->get();

        return view('AdminSite.PerubahanUnit.PindahKepemilikan.edit', $data);
    }

    public function editTPU($id)
    {
        $connTenantUnit = ConnectionDB::setConnection(new TenantUnit());
        $connUnit = $this->setConnection(new Unit());
        $periodeSewa = $this->setConnection(new PeriodeSewa());
        $connOwner = $this->setConnection(new OwnerH());

        // $data['tenantunit'] = $connTenantUnit->where('id_tenant_unit', $id)->first();
        $data['tenantunit'] = $connTenantUnit->find($id);
        $data['id_tenant'] = $id;
        $data['units'] = $connUnit->get();
        $data['owners'] = $connOwner->get();
        $data['periodeSewa'] = $periodeSewa->get();
        $data['getCreateUnits'] = $this->getUnitIDFromTU();

        return view('AdminSite.PerubahanUnit.TidakPerpanjangUnit.edit', $data);
    }

    public function editPerubahan($id)
    {
        $connTenantUnit = ConnectionDB::setConnection(new TenantUnit());
        $connUnit = $this->setConnection(new Unit());
        $periodeSewa = $this->setConnection(new PeriodeSewa());
        $connOwner = $this->setConnection(new OwnerH());

        // $data['tenantunit'] = $connTenantUnit->where('id_tenant_unit', $id)->first();
        $data['tenantunit'] = $connTenantUnit->find($id);
        $data['id_tenant'] = $id;
        $data['units'] = $connUnit->get();
        $data['owners'] = $connOwner->get();
        $data['periodeSewa'] = $periodeSewa->get();
        $data['getCreateUnits'] = $this->getUnitIDFromTU();

        return view('AdminSite.PerubahanUnit.Perubahan.edit', $data);
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
    public function destroy($id)
    {
        //
    }
}
