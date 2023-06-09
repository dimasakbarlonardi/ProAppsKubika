<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\MonthlyArTenant;

class MonthlyArTenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new MonthlyArTenant());

        $data ['monthlyartenants'] = $conn->get();

        return view('AdminSite.MonthlyArTenant.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.MonthlyArTenant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $conn = ConnectionDB::setConnection(new MonthlyArTenant());
            
            DB::beginTransaction();
    
            $conn->create([
                'id_monthly_ar_tenant' => $request->id_monthly_ar_tenant ,
                'id_site' => $request->id_site ,
                'id_tower' => $request->id_tower ,
                'id_unit' => $request->id_unit ,
                'id_tenant' => $request->id_tenant ,
                'no_monthly_invoice' => $request->no_monthly_invoice ,
                'periode_bulan' => $request->periode_bulan ,
                'periode_tahun' => $request->periode_tahun,
                'total_tagihan_ipl' => $request->total_tagihan_ipl ,
                'total_tagihan_utility' => $request->total_tagihan_utility ,
                'total_denda' => $request->total_denda ,
                'biaya_lain' => $request->biaya_lain ,
                'tgl_jt_invoice' => $request->tgl_jt_invoice ,
                'tgl_bayar_invoice' => $request->tgl_bayar_invoice
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Monthly AR Tenant');

            return redirect()->route('monthlyartenants.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Monthly AR Tenant');

            return redirect()->route('monthlyartenants.index');
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
    public function edit($id)
    {
        $conn = ConnectionDB::setConnection(new MonthlyArTenant());

        $data['monthlyartenant'] = $conn->find($id);

        return view('AdminSite.MonthlyArTenant.edit', $data);
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
        $conn = ConnectionDB::setConnection(new MonthlyArTenant());

        $monthlyartenant = $conn->find($id);
        $monthlyartenant->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Monthly Ar Tenant');

        return redirect()->route('monthlyartenants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new MonthlyArTenant());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus Monthly AR Tenant');

        return redirect()->route('AdminSite.MonthlyArTenants.index');
    }
}
