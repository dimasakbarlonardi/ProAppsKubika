<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\StatusRequest;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StatusRequestController extends Controller
{
    public function setConnection($model)
    {
        $request = Request();
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $model = $model;
        $model->setConnection($conn);

        return $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connStatusRequest = $this->setConnection(new StatusRequest());

        $data['statusrequests'] = $connStatusRequest->get();

        return view('AdminSite.StatusRequest.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.StatusRequest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $connStatusRequest = $this->setConnection(new StatusRequest());

        try {
            DB::beginTransaction();

            $count = $connStatusRequest->count();
            $count += 1;
   

            $connStatusRequest->create([
                'id_status_request' => $count,
                'status_request' => $request->status_request,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan status request');

            return redirect()->route('statusrequests.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan status request');

            return redirect()->route('statusrequests.index');
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
        $connStatusRequest = $this->setConnection(new StatusRequest());
        $data['statusrequest'] = $connStatusRequest->where('id_status_request', $id)->first();

        return view('AdminSite.StatusRequest.edit', $data);
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
        $connStatusRequest = $this->setConnection(new StatusRequest());
        $count = $connStatusRequest->count();

        $connStatusRequest->where('id_status_request', $id)->update([
            'id_status_request' => $count,
            'status_request' => $request->status_request,
        ]);

        Alert::success('Berhasil', 'Berhasil Mengupdate Status Request');

        return redirect()->route('statusrequests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $connStatusRequest = $this->setConnection(new StatusRequest());
        $connStatusRequest->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus Status Request');

        return redirect()->route('statusrequests.index');
    }
}
