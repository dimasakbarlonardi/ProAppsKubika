<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\RequestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RequestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new RequestType());

        $data['requests'] = $conn->get();

        return view('AdminSite.RequestType.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.RequestType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new RequestType());

        try {

            DB::beginTransaction();

            $conn->create($request->all());

            DB::commit();

            Alert::success('Success', 'Successfully Added Request Attendance');

            return redirect()->route('requestattendance.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed', 'Failed to Add Request Attendance');
            return redirect()->route('requestattendance.index');
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
        $conn = ConnectionDB::setConnection(new RequestType());

        $data['request'] = $conn->where('id', $id)->first();

        return view('AdminSite\RequestType\edit', $data);
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
        $conn = ConnectionDB::setConnection(new RequestType());

        $jenisrequest = $conn->find($id);
        $jenisrequest->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate ruang reservation');
        return redirect()->route('requestattendance.index');
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
