<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\IdCard;
use App\Models\JenisKelamin;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Login;
use App\Models\OwnerH;
use App\Models\Site;
use App\Models\StatusHunianTenant;
use App\Models\User;
use FTP\Connection;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TenantController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Tenant());

        $data['tenants'] = $conn->get();

        return view('AdminSite.Tenant.index', $data);
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
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $statushunian = ConnectionDB::setConnection(new StatusHunianTenant());

        $idcard = ConnectionDB::setConnection(new IdCard());

        $owner = ConnectionDB::setConnection(new OwnerH());

        $data['statushunians'] = $statushunian->get();
        $data['idcards'] = $idcard->get();
        $data['idusers'] = Login::where('id', $user_id)->first();
        $data['idpemiliks'] = $owner->get();
        $data['tenants'] = $connTenant->get();


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
        $connTenant =  ConnectionDB::setConnection(new Tenant());

        try {
            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();
            $site = $login->site->id_site;

            $count = $connTenant->count();
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            }

            $connTenant->create([
                'id_tenant' => $count,
                'id_site' => $site,
                'id_user' => $id_user,
                'id_card_type' => $request->id_card_type,
                'nik_tenant' => $request->nik_tenant,
                'nama_tenant' => $request->nama_tenant,
                'id_statushunian_tenant' => $request->id_statushunian_tenant,
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

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan tenant');

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

        $data['tenant'] = $connTenant->where('id_tenant', $id)->first();
        $data['idcards'] = $connIdCard->get();
        $data['statushunians'] = $connStatusHunian->get();


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
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $connTenant->where('id_tenant', $id)->update([
            'id_site' => $request->id_site,
            'id_user' => $request->id_user,
            'id_card_type' => $request->id_card_type,
            'nik_tenant' => $request->nik_tenant,
            'nama_tenant' => $request->nama_tenant,
            'id_statushunian_tenant' => $request->id_statushunian_tenant,
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
