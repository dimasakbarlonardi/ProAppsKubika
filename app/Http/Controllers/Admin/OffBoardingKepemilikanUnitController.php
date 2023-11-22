<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\KepemilikanUnitOff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OffBoardingKepemilikanUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new KepemilikanUnitOff());

        $data['offkepemilikanunits'] = $conn->get();

        return view('AdminSite.OffBoardingKepemilikanUnit.index', $data);
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
        $conn = ConnectionDB::setConnection(new KepemilikanUnitOff());
        try {
            
            DB::beginTransaction();

            $conn->create([
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan OffBoarding KepemilikanUnit');

            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan OffBoarding KepemilikanUnit');

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
