<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\ApproveRequest;
use App\Models\ApproveWR;
use App\Models\Karyawan;
use App\Models\Login;
use App\Models\Role;
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

    public function systemApprove()
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());
        $connRole = ConnectionDB::setConnection(new Role());

        $data['karyawans'] = $connKaryawan->get();
        $data['approve'] = $connApprove->get();
        $data['roles'] = $connRole->get();

        return view('AdminSite.Approve.index', $data);
    }

    public function editSystemApprove($id)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connRole = ConnectionDB::setConnection(new Role());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $data['roles'] = $connRole->get();
        $data['karyawans'] = $connKaryawan->get();
        $data['approve'] = $connApprove->find($id);

        switch ($id) {
            case 1:
                return view('AdminSite.Approve.request', $data);
                break;
            case 2:
                return view('AdminSite.Approve.work-request', $data);
                break;
            case 3:
                return view('AdminSite.Approve.work-order', $data);
                break;
            case 4:
                return view('AdminSite.Approve.request-permit', $data);
                break;
            case 5:
                return view('AdminSite.Approve.work-permit', $data);
                break;
            case 6:
                return view('AdminSite.Approve.bapp', $data);
                break;
            case 7:
                // return view('AdminSite.Approve.request', $data);
                break;
            case 8:
                // return view('AdminSite.Approve.request', $data);
                break;
        }
    }

    public function updateSystemApprove(Request $request, $id)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());

        if ($id == 1) {
            $approve = $connApprove->find(1);
        }
        if ($id == 2) {
            $approve = $connApprove->find(2);
        }
        if ($id == 3) {
            $approve = $connApprove->find(3);
        }
        if ($id == 4) {
            $approve = $connApprove->find(4);
        }
        if ($id == 5) {
            $approve = $connApprove->find(5);
        }
        if ($id == 6) {
            $approve = $connApprove->find(6);
        }
        if ($id == 7) {
            $approve = $connApprove->find(7);
        }
        if ($id == 8) {
            $approve = $connApprove->find(8);
        }

        $approve->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate approve');

        return redirect()->back();
    }
}
