<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Imports\SecurityParameter;
use App\Models\ParameterSecurity;
use Doctrine\DBAL\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Excel;

class ParameterSecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ParameterSecurity());

        $data['ParameterSecurity'] = $conn->get();

        return view('AdminSite.ParameterSecurity.index', $data);
    }

    public function import(Request $request)
    {
        $file = $request->file('file_excel');

        Excel::import(new SecurityParameter(), $file);

        Alert::success('Success', 'Success import data');

        return redirect()->route('Parameter-Security.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.ParameterSecurity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ParameterSecurity());

        try {
            DB::beginTransaction();

            $conn->create([
            'id' => $request->id,
            'name_parameter_security' => $request->name_parameter_security
            ]);

            DB::commit();

            Alert::success('Success', 'Successfully Added Inspection Security Parameter');
            return redirect()->route('Parameter-Security.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);

            Alert::success('Failed', 'Failed to Add Inspection Security Parameter');
            return redirect()->route('Parameter-Security.index');
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
        $conn = ConnectionDB::setConnection(new ParameterSecurity());

        $data['ParameterSecurity'] = $conn->find($id);

        return view('AdminSite.ParameterSecurity.edit', $data);
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
        $conn = ConnectionDB::setConnection(new ParameterSecurity());

        $parametersecurity = $conn->find($id);
        $parametersecurity->update($request->all());

        Alert::success('Success', 'Successfully Updated Inspection Security Parameter');
        return redirect()->route('Parameter-Security.index');
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
