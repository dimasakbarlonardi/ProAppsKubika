<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hunian;
use App\Models\Login;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class HunianController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new Hunian();
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

        $data['hunians'] = $conn->get();

        return view('AdminSite.Hunian.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Hunian.create');
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

            $conn->create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Hunian');

            return redirect()->route('floors.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Hunian');

            return redirect()->route('floors.index');
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
