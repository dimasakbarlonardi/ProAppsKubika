<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisKendaraan;
use App\Models\KendaraanTenant;
use App\Models\Login;
use App\Models\Unit;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class KendaraanTenantController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new KendaraanTenant();
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

        $data['kendaraans'] = $conn->get();

        return view('AdminSite.TenantKendaraan.index', $data);
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

        $unit = new Unit();
        $unit->setConnection($conn);

        $tenant = new Tenant();
        $tenant->setConnection($conn);

        $jeniskendaraan = new JenisKendaraan();
        $jeniskendaraan->setConnection($conn);

        $data['units'] = $unit->get();
        $data['tenants'] = $tenant->get();
        $data['jeniskendaraans'] = $jeniskendaraan->get();

        return view('AdminSite.TenantKendaraan.create', $data);
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

            $count = $conn->count();
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            }

            $conn->create([
                'id_tenant_vehicle' => $count,
                'id_tenant' => $request->id_tenant,
                'id_unit' => $request->id_unit,
                'id_jenis_kendaraan' => $request->id_jenis_kendaraan,
                'no_polisi' => $request->no_polisi,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Kendaraan Tenant');

            return redirect()->route('kendaraans.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Kendaraan Tenant');

            return redirect()->route('kendaraans.index');
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
        $data['kendaraan'] = $conn->where('id_tenant_vehicle', $id)->first();

        return view('AdminSite.TenantKendaraan.edit', $data);
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

        $membertenant = $conn->find($id);
        $membertenant->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Kendaraan Tenant');

        return redirect()->route('kendaraans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $conn = $this->setConnection($request);
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus Kendaraan Tenant');

        return redirect()->route('kendaraans.index');
    }
}
