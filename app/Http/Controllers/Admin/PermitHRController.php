<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\PermitHR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PermitHRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new PermitHR());

        $data['permits'] = $conn->get();

        return view('AdminSite.PermitHR.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.PermitHR.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new PermitHR());

        try {

            DB::beginTransaction();

            $conn->create($request->all());

            DB::commit();

            Alert::success('Success', 'Successfully Added Permit Type');

            return redirect()->route('permithr.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed', 'Failed to Add Permit Type');
            return redirect()->route('permithr.index');
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
        $conn = ConnectionDB::setConnection(new PermitHR());

        $data['permit'] = $conn->where('id', $id)->first();

        return view('AdminSite.PermitHR.edit', $data);
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
        $conn = ConnectionDB::setConnection(new PermitHR());

        $permit = $conn->find($id);
        $permit->update($request->all());

        Alert::success('Success', 'Successfully Updated Permit Type');
        return redirect()->route('permithr.index');
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
