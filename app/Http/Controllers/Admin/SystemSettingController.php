<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\System;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SystemSettingController extends Controller
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

    public function index()
    {
        $connSystem = $this->setConnection(new System());

        $data['system'] = $connSystem->find(1);

        return view('AdminSite.SystemSetting.index', $data);
    }

    public function store(Request $request)
    {
        $connSystem = $this->setConnection(new System());

        $connSystem = $connSystem->find(1);
        $connSystem->update($request->all());

        Alert::success('Sukses', 'Berhasil mengupdate setting');

        return redirect()->back();
    }
}
