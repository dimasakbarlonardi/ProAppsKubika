<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Imports\TenantImport;
use App\Http\Controllers\Controller;
use App\Models\IdCard;
use App\Models\JenisKelamin;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Login;
use App\Models\OwnerH;
use App\Models\Site;
use App\Models\StatusHunianTenant;
use App\Models\StatusKawin;
use App\Models\Tower;
use App\Models\Unit;
use App\Models\User;
use FTP\Connection;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Excel;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Tenant());
        $connTower = ConnectionDB::setConnection(new Tower());
        $connUnit = ConnectionDB::setConnection(new Unit());

        $data['tenants'] = $conn->get();
        $data['towers'] = $connTower->get();
        $data['units'] = $connUnit->get()->groupby('nama_unit');

        return view('AdminSite.Tenant.index', $data);
    }

    public function importTenant(Request $request)
    {
        $file = $request->file('file_excel');

        Excel::import(new TenantImport(), $file);

        Alert::success('Success', 'Success import data');

        return redirect()->route('tenants.index');
    }

    public function filteredData(Request $request)
    {
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $tenants = $connTenant->where('deleted_at', null);
        $data['id_tower'] = null;
        $data['nama_unit'] = null;
        // if ($user->user_category == 3) {
        //     $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
        //     $tickets = $connRequest->where('id_tenant', $tenant->id_tenant)->latest();
        // } else {
        //     $tickets = $connRequest->where('deleted_at', null);
        // }

        // if ($request->valueString) {
        //     $valueString = $request->valueString;
        //     $tickets = $tickets->where('judul_request', 'like', '%' . $valueString . '%')
        //         ->orWhereHas('Tenant', function($q) use ($valueString) {
        //             $q->where('nama_tenant', 'like', '%' . $valueString . '%');
        //         })->orWhere('no_tiket', 'like', '%' . $valueString . '%');
        // }
        if ($request->tower != 'all') {
            $tower_id = $request->tower;

            $tenants = $tenants->whereHas('TenantUnit.Unit.Tower', function ($q) use ($tower_id) {
                $q->where('id_tower', $tower_id);
            });
            $data['id_tower'] = $tower_id;
        }

        if ($request->unit != 'all') {
            $nama_unit = $request->unit;

            $tenants = $tenants->whereHas('TenantUnit.Unit', function ($q) use ($nama_unit) {
                $q->where('nama_unit', $nama_unit);
            });
            $data['nama_unit'] = $nama_unit;
        }

        if ($request->has('searchTenant') && !empty($request->searchTenant)) {
            $searchTenant = $request->searchTenant;
    
            $tenants = $tenants->where('nama_tenant', 'like', '%' . $searchTenant . '%');
        }

        // $tickets = $tickets->orderBy('id', 'DESC');
        $data['tenants'] = $tenants->orderBy('nama_tenant','asc')->get();

        return response()->json([
            'html' => view('AdminSite.Tenant.table-data', $data)->render()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = $request->user()->id;
        $statuskawin = ConnectionDB::setConnection(new StatusKawin());
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $statushunian = ConnectionDB::setConnection(new StatusHunianTenant());
        $idcard = ConnectionDB::setConnection(new IdCard());
        $owner = ConnectionDB::setConnection(new OwnerH());

        $data['statushunians'] = $statushunian->get();
        $data['idcards'] = $idcard->get();
        $data['idusers'] = Login::where('id', $user_id)->first();
        $data['idpemiliks'] = $owner->get();
        $data['tenants'] = $connTenant->get();
        $data['statuskawins'] = $statuskawin->get();

        return view('AdminSite.Tenant.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            'id_card_type' => 'required',
            'id_statushunian_tenant' => 'required',
            'id_status_kawin' => 'required',
        ];

        $customMessages = [
            Alert::error('Failed', 'Complete the Unfilled Data')
        ];

        $validator = Validator::make($request->all(), $validationRules, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $connTenant =  ConnectionDB::setConnection(new Tenant());

        $checkNIK = $connTenant->where('nik_tenant', $request->nik_tenant)->first();
        $checkEmail = $connTenant->where('email_tenant', $request->email_tenant)->first();

        if (isset($checkNIK)) {
            Alert::error('Maaf', 'NIK sudah terdaftar');
            return redirect()->back()->withInput();
        }

        if (isset($checkEmail)) {
            Alert::error('Maaf', 'Email sudah terdaftar');
            return redirect()->back()->withInput();
        }

        $count = $connTenant->count();
        $count = $count + 1;

        try {
            DB::beginTransaction();

            $site = $request->user()->id_site;

            $tenant = $connTenant->create([
                'id_tenant' => sprintf("%03d", $count),
                'email_tenant' => $request->email_tenant,
                'id_site' => $site,
                'id_card_type' => $request->id_card_type,
                'nik_tenant' => $request->nik_tenant,
                'nama_tenant' => $request->nama_tenant,
                'id_statushunian_tenant' => $request->id_statushunian_tenant,
                'id_status_kawin' => $request->id_status_kawin,
                'kewarganegaraan' => $request->kewarganegaraan,
                'masa_berlaku_id' => $request->masa_berlaku_id,
                'alamat_ktp_tenant' => $request->alamat_ktp_tenant,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'alamat_tinggal_tenant' => $request->alamat_tinggal_tenant,
                'no_telp_tenant' => $request->no_telp_tenant,
                'nik_pasangan_penjamin' => $request->nik_pasangan_penjamin,
                'nama_pasangan_penjamin' => $request->nama_pasangan_penjamin,
                'alamat_ktp_pasangan_penjamin' => $request->alamat_ktp_pasangan_penjamin,
                'alamat_tinggal_pasangan_penjamin' => $request->alamat_tinggal_pasangan_penjamin,
                'hubungan_penjamin' => $request->hubungan_penjamin,
                'no_telp_penjamin' => $request->no_telp_penjamin,
                'id_status_kawin' => $request->id_status_kawin,
                'profile_picture' => '/storage/img/proapps.png',
            ]);

            $file = $request->file('profile_picture');

            if ($file) {
                $fileName = $tenant->id_tenant . '-' .   $file->getClientOriginalName();
                $outputTenantImage = '/public/' . $site . '/img/profile_picture/' . $fileName;
                $tenantImage = '/storage/' . $site . '/img/profile_picture/' . $fileName;

                Storage::disk('local')->put($outputTenantImage, File::get($file));

                $tenant->profile_picture = $tenantImage;
                $tenant->save();
            }
            DB::commit();

            Alert::success('Success', 'Tenant added successfully');

            return redirect()->route('tenants.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan tenant');

            return redirect()->route('tenants.index');
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
        $connTenant =  ConnectionDB::setConnection(new Tenant());
        $user_id = $request->user()->id;

        $data['tenant'] = $connTenant->where('id_tenant', $id)->first();
        $data['idusers'] =  Login::where('id', $user_id)->get();

        return view('AdminSite.Tenant.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $connTenant =  ConnectionDB::setConnection(new Tenant());
        $connIdCard = ConnectionDB::setConnection(new IdCard());
        $connStatusHunian = ConnectionDB::setConnection(new StatusHunianTenant());
        $connStatusKawin = ConnectionDB::setConnection(new StatusKawin());

        $data['tenant'] = $connTenant->where('id_tenant', $id)->first();
        $data['idcards'] = $connIdCard->get();
        $data['statushunians'] = $connStatusHunian->get();
        $data['statuskawins'] = $connStatusKawin->get();


        return view('AdminSite.Tenant.edit', $data);
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
        $site = $request->user()->id_site;
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $connTenant->where('id_tenant', $id)->update([
            'id_site' => $request->id_site,
            'id_user' => $request->id_user,
            'id_card_type' => $request->id_card_type,
            'nik_tenant' => $request->nik_tenant,
            'nama_tenant' => $request->nama_tenant,
            'id_statushunian_tenant' => $request->id_statushunian_tenant,
            'id_status_kawin' => $request->id_status_kawin,
            'kewarganegaraan' => $request->kewarganegaraan,
            'masa_berlaku_id' => $request->masa_berlaku_id,
            'alamat_ktp_tenant' => $request->alamat_ktp_tenant,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'alamat_tinggal_tenant' => $request->alamat_tinggal_tenant,
            'no_telp_tenant' => $request->no_telp_tenant,
            'nik_pasangan_penjamin' => $request->nik_pasangan_penjamin,
            'nama_pasangan_penjamin' => $request->nama_pasangan_penjamin,
            'alamat_ktp_pasangan_penjamin' => $request->alamat_ktp_pasangan_penjamin,
            'alamat_tinggal_pasangan_penjamin' => $request->alamat_tinggal_pasangan_penjamin,
            'hubungan_penjamin' => $request->hubungan_penjamin,
            'no_telp_penjamin' => $request->no_telp_penjamin
        ]);

        $file = $request->file('profile_picture');

        if ($file) {
            $fileName = $connTenant->id_tenant . '-' .   $file->getClientOriginalName();
            $outputTenantImage = '/public/' . $site . '/img/profile_picture/' . $fileName;
            $tenantImage = '/storage/' . $site . '/img/profile_picture/' . $fileName;

            Storage::disk('local')->put($outputTenantImage, File::get($file));

            $connTenant->profile_picture = $tenantImage;
            $connTenant->save();
        }

        Alert::success('Berhasil', 'Berhasil mengupdate tenant');

        return redirect()->route('tenants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new Tenant());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus tenant');

        return redirect()->route('tenants.index');
    }
}
