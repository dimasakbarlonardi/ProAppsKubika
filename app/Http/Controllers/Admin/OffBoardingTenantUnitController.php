<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\TenantUnit;
use App\Models\TenantUnitOFF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OffBoardingTenantUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $conn = ConnectionDB::setConnection(new TenantUnitOFF());

        $data['offtenantunits'] = $conn->get();

        return view('AdminSite.OffBoardingTenantUnit.index', $data);
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
        $conn = ConnectionDB::setConnection(new TenantUnitOFF());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan OffBoarding TenantUnit');

            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan OffBoarding TenantUnit');

            // return redirect()->route('housekeeping.index');
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
    public function destroy($id)
    {
        //
    }
}
