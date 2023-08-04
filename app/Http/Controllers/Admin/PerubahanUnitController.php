<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\KepemilikanUnit;
use App\Models\KepemilikanUnitOff;
use App\Models\Login;
use App\Models\OpenTicket;
use App\Models\OwnerH;
use App\Models\PeriodeSewa;
use App\Models\StatusHunianTenant;
use App\Models\Tenant;
use App\Models\TenantUnit;
use App\Models\TenantUnitOFF;
use App\Models\Unit;
use App\Models\WorkRequest;
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

    public function unitBy($id)
    {
        $connUnit = ConnectionDB::setConnection(new TenantUnit());
        // 0042120101
        $tenantunit = $connUnit->where('id_unit', '0042120103')->get();
        dd($tenantunit);
        return response()->json(['tenantunit' => $tenantunit]);
    }

    public function kepemilikanByID($id)
    {
        $connkepemilikan = ConnectionDB::setConnection(new KepemilikanUnit());

        $connkepemilikan = $connkepemilikan->where('id_unit', $id)->first();

        return response()->json(['unit' => $connkepemilikan]);
    }

    public function perubahanByID($id)
    {
        $connperubahan = ConnectionDB::setConnection(new TenantUnit());

        $connperubahan = $connperubahan->where('id_unit', $id)->first();

        return response()->json(['unit' => $connperubahan]);
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


        $checkTGL = $connTenantUnit->where('tgl_masuk', $request->tgl_masuk)->first();
        $checTGLOUT = $connTenantUnit->where('tgl_keluar', $request->tgl_keluar)->first();

        if (isset($checkTGL)) {
            Alert::error('Maaf', 'Tanggal sewa sama');
            return redirect()->back()->withInput();
        }

        if (isset($checTGLOUT)) {
            Alert::error('Maaf', 'Tanggal sewa sama');
            return redirect()->back()->withInput();
        }

        $tu = $connTenantUnit->where('id_tenant_unit', $id)->first();

        $createOff = $connTUOFF;
        $createOff->id_pemilik = $tu->id_pemilik;
        $createOff->id_tenant = $tu->id_tenant;
        $createOff->id_unit = $tu->id_unit;
        $createOff->id_periode_sewa = $tu->id_periode_sewa;
        $createOff->tgl_masuk = $tu->tgl_masuk;
        $createOff->tgl_keluar = $tu->tgl_keluar;
        $createOff->sewa_ke = $tu->sewa_ke;
        $createOff->keterangan = $request->keterangan;
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
        $createOff->id_periode_sewa = $tu->id_periode_sewa;
        $createOff->tgl_masuk = $tu->tgl_masuk;
        $createOff->tgl_keluar = $tu->tgl_keluar;
        $createOff->sewa_ke = $tu->sewa_ke;
        $createOff->keterangan = $request->keterangan;
        $createOff->save();

        $tu->id_unit = $request->id_unit;
        $tu->id_pemilik = $request->id_pemilik;
        $tu->id_periode_sewa = $request->id_periode_sewa;
        $tu->tgl_masuk = $request->tgl_masuk;
        $tu->tgl_keluar = $request->tgl_keluar;
        $tu->tgl_jatuh_tempo_ipl = $request->tgl_jatuh_tempo_ipl;
        $tu->tgl_jatuh_tempo_util = $request->tgl_jatuh_tempo_util;
        $tu->sewa_ke = $tu->sewa_ke;
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
        $createOff->tgl_keluar = $request->tgl_keluar;
        $createOff->no_bukti_milik = $tu->no_bukti_milik;
        $createOff->keterangan = $request->keterangan;
        $createOff->save();

        $tu->id_unit = $request->id_unit;
        $tu->id_pemilik = $request->id_pemilik;
        $tu->id_status_hunian = $tu->id_status_hunian;
        $tu->tgl_mulai = $tu->tgl_mulai;
        $tu->no_bukti_milik = $tu->no_bukti_milik;
        $tu->keterangan = $tu->keterangan;
        $tu->save();

        DB::commit();

        Alert::success('Berhasil', 'Berhasil Pindah Kepemilikan Unit');

        return redirect()->route('perubahanunits.index');
    }

    public function deleteTenantUnit(Request $request, $id)
    {
        $conn = $this->setConnection(new TenantUnit());
        $connTUOFF = ConnectionDB::setConnection(new TenantUnitOFF());

        $nowDate = Carbon::now();

        $conn = $conn->where('id_tenant_unit', $id)->first();
        $conn->unit->isempty = 0;
        $conn->unit->save();
        $conn->delete();

        $connTUOFF->create([
            'id_tenant' => $conn->id_tenant,
            'id_unit' => $conn->id_unit,
            'id_pemilik' => $conn->id_pemilik,
            'id_periode_sewa' => $conn->id_periode_sewa,
            'tgl_masuk' => $conn->tgl_masuk,
            'tgl_keluar' => $conn->tgl_keluar,
            'tgl_sys' => $nowDate,
            'keterangan' => $request->keterangan,
            'sewa_ke' => $conn->sewa_ke,
        ]);
        DB::commit();

        Alert::success('Berhasil', 'Berhasil tidak perpanjang unit');

        return redirect()->route('perubahanunits.index');
    }

    public function deleteKepemilikanUnit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new KepemilikanUnit());
        $connKUOFF = ConnectionDB::setConnection(new KepemilikanUnitOff());

        $nowDate = Carbon::now();

        $conn = $conn->where('id_pemilik_unit', $id)->first();
        $conn->unit->isempty = 0;
        $conn->unit->save();
        $conn->delete();

        $connKUOFF->create([
            'id_pemilik' => $conn->id_pemilik,
            'id_unit' => $conn->id_unit,
            'id_status_hunian' => $conn->id_status_hunian,
            'tgl_masuk' => $conn->tgl_masuk,
            'tgl_keluar' => $request->tgl_keluar,
            'tgl_sys' => $nowDate,
            'no_bukti_milik' => $conn->no_bukti_milik,
            'keterangan' => $request->keterangan,
        ]);
        DB::commit();

        Alert::success('Berhasil', 'Berhasil perubahan kepemilikan unit');

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
    public function show(Request $request,$id)
    {
        $conn = ConnectionDB::setConnection(new TenantUnit());
        $connTenantUnit = $this->setConnection(new TenantUnit());
        $connTicket = ConnectionDB::setConnection(new OpenTicket());

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
        $connTenantUnit = ConnectionDB::setConnection(new TenantUnit());

        $data['kepemilikans'] = $conn->where('id_pemilik', $id)->first();
        $data['id_pemilik'] = $id;
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

        $data['tenantunit'] = $connTenantUnit->where('id_tenant_unit', $id)->first();
        // $data['tenantunit'] = $connTenantUnit->find($id);
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

        $data['tenant_unit'] = $connTenantUnit->get();
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

    public function validationPerubahan(Request $request)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());

        $tickets = $connTicket->where('id_user', $request->id_user)
        ->where('id_unit', $request->id_unit)
        ->where('status_request', '!=', 'COMPLETE')
        ->get();
        $errors = [];

        foreach ($tickets as $ticket) {

            $tiket['error_header'] = $ticket->no_tiket;
            $tiket['error_status'] = $ticket->status_request;
            $tiket['type'] = 'Tiket';

            array_push($errors, $tiket);

            if ($ticket->WorkRequest) {
                $wr['error_header'] = $ticket->WorkRequest->no_work_request;
                $wr['error_status'] = $ticket->WorkRequest->status_request;
                $wr['type'] = 'Work Request';
                array_push($errors, $wr);

            }

            if ($ticket->WorkOrder) {
                $wo['error_header'] = $ticket->WorkOrder->no_work_order;
                $wo['error_status'] = $ticket->WorkOrder->status_request;
                $wo['type'] = 'Work Order';
                array_push($errors, $wo);
            }
        }

        return response()->json(['errors' => $errors]);
    }

    // public function validationPerubahanOwner(Request $request)
    // {
    //     $connTicket = ConnectionDB::setConnection(new OpenTicket());

    //     $tickets = $connTicket->where('id_tenant', $request->id_tenant)
    //     ->where('id_unit', $request->id_unit)
    //     ->where('status_request', '!=', 'COMPLETE')
    //     ->get();
    //     $errors = [];

    //     foreach ($tickets as $ticket) {

    //         $tiket['error_header'] = $ticket->no_tiket;
    //         $tiket['error_status'] = $ticket->status_request;
    //         $tiket['type'] = 'Tiket';

    //         array_push($errors, $tiket);

    //         if ($ticket->WorkRequest) {
    //             $wr['error_header'] = $ticket->WorkRequest->no_work_request;
    //             $wr['error_status'] = $ticket->WorkRequest->status_request;
    //             $wr['type'] = 'Work Request';
    //             array_push($errors, $wr);

    //         }

    //         if ($ticket->WorkOrder) {
    //             $wo['error_header'] = $ticket->WorkOrder->no_work_order;
    //             $wo['error_status'] = $ticket->WorkOrder->status_request;
    //             $wo['type'] = 'Work Order';
    //             array_push($errors, $wo);
    //         }
    //     }

    //     return response()->json(['errors' => $errors]);
    // }
}
