<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\JenisKendaraan;
use App\Models\KendaraanTenant;
use App\Models\TenantUnit;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\MemberTenant;
use App\Models\OwnerH;
use App\Models\PeriodeSewa;
use App\Models\StatusTinggal;
use App\Models\Tenant;
use App\Models\TenantUnitOFF;
use App\Models\Tower;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Unit;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Session\Session;

class TenantUnitController extends Controller
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

    public static function generateTenantUnitID($tu)
    {
        $tu = $tu->count();
        $tu++;
        $tu_id = str_pad($tu, 9, '0', STR_PAD_LEFT);

        return $tu_id;
    }

    public function index($id)
    {
        $conn = ConnectionDB::setConnection(new TenantUnit());

        $data['tenantunits'] = $conn->get();

        return view('AdminSite.TenantUnit.index', $data);
    }

    public function show($id)
    {
        $conn = ConnectionDB::setConnection(new TenantUnit());

        $data['tenantunits'] = $conn->where('id_tenant_unit', $id)->first();

        return view('AdminSite.TenantUnit.Unit.show', $data);
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

    public function getIDunitFromTU()
    {
        $tenant_units = $this->setConnection(new TenantUnit());
        $tenant_units['getIDunitFromTU'] = $tenant_units->get();

        $tenant_units = $tenant_units->whereNotIn('id_tenant_unit', $tenant_units)->get();

        return $tenant_units;
    }

    public function getTenantUnit($id)
    {
        $connTenantUnit = $this->setConnection(new TenantUnit());
        $connUnit = $this->setConnection(new Unit());
        $connTenant = $this->setConnection(new Tenant());
        $connPeriodeSewa = $this->setConnection(new PeriodeSewa());
        $connMemberTenant = $this->setConnection(new MemberTenant());
        $connKendaraanTenant = $this->setConnection(new KendaraanTenant());
        $connJenisKendaraan = $this->setConnection(new JenisKendaraan());
        $connStatusTinggal = $this->setConnection(new StatusTinggal());
        $connOwner = $this->setConnection(new OwnerH());

        $data['tenant_units'] = $connTenantUnit->where('id_tenant', $id)->get();
        $data['tenant'] = $connTenant->find($id);
        $data['getCreateUnits'] = $this->getUnitIDFromTU();

        $data['getIDunitFromTU'] = $this->getIDunitFromTU();

        $data['units'] = $connUnit->get();
        $data['periodeSewa'] = $connPeriodeSewa->get();
        $data['tenant_members'] = $connMemberTenant->where('id_tenant', $id)->get();
        $data['kendaraan_tenants'] = $connKendaraanTenant->where('id_tenant', $id)->get();
        $data['jenis_kendaraan'] = $connJenisKendaraan->get();
        $data['statustinggals'] = $connStatusTinggal->get();
        $data['owners'] = $connOwner->get();

        return view('AdminSite.TenantUnit.create', $data);
    }

    public function storeTenantUnit(Request $request)
    {
        $connTenantUnit = $this->setConnection(new TenantUnit());
       

        $id_tenant_unit = $this->generateTenantUnitID($connTenantUnit);

        $connTenantUnit->create([
            'id_tenant_unit' => $id_tenant_unit,
            'id_unit' => $request->id_unit,
            'id_pemilik' => $request->id_pemilik,
            'id_tenant' => $request->id_tenant,
            'id_periode_sewa' => $request->id_periode_sewa,
            'tgl_masuk' => $request->tgl_masuk,
            'tgl_keluar' => $request->tgl_keluar,
            'tgl_jatuh_tempo_ipl' => $request->tgl_jatuh_tempo_ipl,
            'tgl_jatuh_tempo_util' => $request->tgl_jatuh_tempo_util,
            'sewa_ke' => 1
        ]);

        Alert::success('Berhasil', 'Berhasil Menambah Tenant Unit');

        return redirect()->back();
    }

    

    public function storeTenantMember(Request $request)
    {
        $connTenantMember = $this->setConnection(new MemberTenant());

        try {
            DB::beginTransaction();

            $count = $connTenantMember->count();
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            }

            $connTenantMember->create([
                'id_tenant_member' => $count,
                'id_unit' => $request->id_unit,
                'id_tenant' => $request->id_tenant,
                'nik_tenant_member' => $request->nik_tenant_member,
                'nama_tenant_member' => $request->nama_tenant_member,
                'hubungan_tenant' => $request->hubungan_tenant,
                'no_telp_member' => $request->no_telp_member,
                'id_status_tinggal' => $request->id_status_tinggal,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Member Tenant');

            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Member Tenant');

            return redirect()->back();
        }
    }

    public function editTenantMember($id)
    {
        $connTenantMember = $this->setConnection(new MemberTenant());
        $connUnit = $this->setConnection(new Unit());
        $connStatusTinggal = $this->setConnection(new StatusTinggal());

        $data['getIDunitFromTU'] = $this->getIDunitFromTU();
        $data['id_tenant'] = $id;
        $data['units'] = $connUnit->get();
        $data['tenantmember'] = $connTenantMember->where('id_tenant_member', $id)->first();
        $data['statustinggals'] = $connStatusTinggal->get();

        return view('AdminSite.TenantUnit.Member.edit', $data)->render();
    }

    public function updateTenantMember(Request $request, $id)
    {
        $connTenantMember = $this->setConnection(new MemberTenant());
        $connTenantMember = $connTenantMember->where('id_tenant_member', $id)->first();

        $connTenantMember->update([
            'id_unit' => $request->id_unit,
            'nik_tenant_member' => $request->nik_tenant_member,
            'nama_tenant_member' => $request->nama_tenant_member,
            'hubungan_tenant' => $request->hubungan_tenant,
            'no_telp_member' => $request->no_telp_member,
            'id_status_tinggal' => $request->id_status_tinggal,
        ]);

        Alert::success('Berhasil', 'Berhasil Mengubah Tenant Member');

        return redirect()->back();
    }

    public function storeTenantVehicle(Request $request)
    {
        $connKendaraanTenant = $this->setConnection(new KendaraanTenant());

        try {
            DB::beginTransaction();

            $count = $connKendaraanTenant->count();
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            }

            $connKendaraanTenant->create([
                'id_tenant_vehicle' => $count,
                'id_tenant' => $request->id_tenant,
                'id_unit' => $request->id_unit,
                'id_jenis_kendaraan' => $request->id_jenis_kendaraan,
                'no_polisi' => $request->no_polisi,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Kendaraan Tenant');

            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Kendaraan Tenant');

            return redirect()->back();
        }
    }

    public function editTenantKendaraan($id)        
    {

        $connTenantKendaraan = $this->setConnection(new KendaraanTenant());
        $connUnit = $this->setConnection(new Unit());
        $connJenisKendaraan = $this->setConnection(new JenisKendaraan());

        // $periodeSewa = $this->setConnection(new PeriodeSewa());
        // $data['id_tenant'] = $id;
        $data['units'] = $connUnit->get();
        // $data['periodeSewa'] = $periodeSewa->get();
        $data['tenantkendaraan'] = $connTenantKendaraan->where('id_tenant_vehicle', $id)->first();
        $data['jenis_kendaraan'] = $connJenisKendaraan->get();

        return view('AdminSite.TenantUnit.Kendaraan.edit', $data)->render();
    }

    public function updateTenantKendaraan(Request $request, $id)
    {
        $conn = $this->setConnection(new KendaraanTenant());

        $membertenant = $conn->find($id);
        $membertenant->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Kendaraan Tenant');

        return redirect()->back();
    }

    public function deleteTenantUnit(Request $request,$id)
    {
        $conn = $this->setConnection(new TenantUnit());
        $connTUOFF = ConnectionDB::setConnection(new TenantUnitOFF());
        $conntenant = ConnectionDB::setConnection(new TenantUnit());

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

        Alert::success('Berhasil', 'Berhasil OffBoarding tenant unit');

        return redirect()->route('getTenantUnit', $conntenant->id_tenant);
    }

    public function deleteTenantMember($id)
    {
        $conn = $this->setConnection(new MemberTenant());

        $conn = $conn->where('id_tenant_member', $id)->first();
        $conn->delete();

        Alert::success('Berhasil', 'Berhasil menghapus tenant member');

        return redirect()->back()->with(['active' => 'member']);
    }

    public function deleteTenantKendaraan($id)
    {
        $conn = $this->setConnection(new KendaraanTenant());

        $conn = $conn->where('id_tenant_vehicle', $id)->first();
        $conn->delete();

        Alert::success('Berhasil', 'Berhasil menghapus kendaraan member');

        return redirect()->back()->with(['active' => 'vehicle']);
    }

    public function getVehicleUnit($id)
    {
        $conn = ConnectionDB::setConnection(new KendaraanTenant());
        $data['kendaraan_tenants'] = $conn->where('id_unit', $id)->get();

        return response()->json([
            'html' => view('AdminSite.TenantUnit.Kendaraan.table', $data)->render(),
        ]);
    }
}
