<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberTenant;
use App\Models\Login;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class MemberTenantController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new MemberTenant();
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

        $data['membertenants'] = $conn->get();

        return view('AdminSite.MemberTenant.index', $data);
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

        $data['units'] = $unit->get();
        $data['tenants'] = $tenant->get();

        return view('AdminSite.MemberTenant.create', $data);
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

            return redirect()->route('membertenants.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Member Tenant');

            return redirect()->route('membertenants.index');
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
        $data['membertenant'] = $conn->where('id_tenant_member', $id)->first();

        return view('AdminSite.MemberTenant.edit', $data);
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

        // $conn->where('id_member_tenant', $id)->update([
          
        //     'nik_tenant_member' => $request->nik_tenant_member,
        //     'nama_tenant_member' => $request->nama_tenant_member,
        //     'hubungan_tenant' => $request->hubungan_tenant,
        //     'no_telp_member' => $request->no_telp_member,
        //     'id_status_tinggal' => $request->id_status_tinggal
        // ]);

        Alert::success('Berhasil', 'Berhasil mengupdate member tenant');

        return redirect()->route('membertenants.index');
        
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

        Alert::success('Berhasil', 'Berhasil menghapus member tenant');

        return redirect()->route('membertenants.index');
    }
}
