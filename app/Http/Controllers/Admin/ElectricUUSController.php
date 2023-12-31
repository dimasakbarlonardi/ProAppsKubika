<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Http\Controllers\Controller;
use App\Imports\ImportElectric;
use App\Models\Approve;
use App\Models\CashReceipt;
use App\Models\CashReceiptDetail;
use App\Models\CompanySetting;
use App\Models\ElectricUUS;
use App\Models\Role;
use App\Models\Site;
use App\Models\System;
use App\Models\Tower;
use App\Models\Unit;
use App\Models\User;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;
use Throwable;

class ElectricUUSController extends Controller
{
    public function index(Request $request)
    {
        $connTower = ConnectionDB::setConnection(new Tower());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connSetting = ConnectionDB::setConnection(new CompanySetting());

        $data['setting'] = $connSetting->find(1);
        $data['elecUSS'] = $this->filteredData($request);
        $data['approve'] = $connApprove->find(9);
        $data['user'] = $request->session()->get('user');
        $data['towers'] = $connTower->get();

        return view('AdminSite.UtilityUsageRecording.Electric.index', $data);
    }

    public function filteredData(Request $request)
    {
        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());

        $records = $connElecUUS->where('deleted_at', null);

        if ($request->input('id_tower')) {
            $id_tower = $request->id_tower;
            $records = $records->whereHas('Unit.Tower', function ($q) use ($id_tower) {
                $q->where('id_tower', $id_tower);
            });
        }

        if ($request->input('select_status')) {
            $status = $request->input('select_status') == '0' ? null : $request->input('select_status');
            $records = $records->where('is_approve', $status);
        }

        if ($request->input('select_period')) {
            $records = $records->where('periode_bulan', $request->input('select_period'));
        }

        if ($request->input('select_year')) {
            $records = $records->where('periode_tahun', $request->input('select_year'));
        }

        $records = $records->paginate(10);

        return $records;
    }

    public function create()
    {
        $id_unit = '0042120104';

        $connUnit = ConnectionDB::setConnection(new Unit());
        $unit = $connUnit->where('id_unit', $id_unit)->first();

        if ($unit->allElectricUUSbyYear) {
            $monthUUS = [];
            foreach ($unit->allElectricUUSbyYear as $uus) {
                $monthUUS[] = $uus->periode_bulan;
            }
        }

        $data['unit'] = $unit;
        $data['monthUUS'] = $monthUUS;

        return view('AdminSite.UtilityUsageRecording.Electric.create', $data);
    }

    public function store($id_unit, Request $request)
    {
        $site = Site::find($request->user()->id_site);
        $user = new User();
        $user = $user->setConnection($site->db_name);
        $user = $user->where('login_user', $request->user()->email)->first();

        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());

        $connElecUUS->create([
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => Carbon::now()->format('Y'),
            'id_unit' => $id_unit,
            'nomor_listrik_awal' => $request->previous,
            'nomor_listrik_akhir' => $request->current,
            'usage' => $request->current - $request->previous,
            'id_user' => $user->id_user
        ]);

        return response()->json(['status' => 'OK']);
    }

    public function approve(Request $request)
    {
        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $approve = $connApprove->find(9);

        foreach ($request->IDs as $id) {
            try {
                DB::beginTransaction();
                $elecUSS = $connElecUUS->where('id', $id)
                    ->where('is_updated', null)
                    ->first();

                if ($elecUSS) {
                    $elecUSS->is_approve = '1';
                    $elecUSS->save();

                    DB::commit();
                }
            } catch (Throwable $e) {
                DB::rollBack();

                return response()->json(['status' => 'failed']);
            }
        }

        $dataNotifTR = [
            'models' => 'UURElectric',
            'notif_title' => null,
            'id_data' => null,
            'sender' => $request->session()->get('user')->id_user,
            'division_receiver' => $approve->approval_2,
            'notif_message' => 'Utility usage recording listrik sudah di approve, terima kasih',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotifTR));

        return response()->json(['status' => 'ok']);
    }

    public function update(Request $request, $id)
    {
        $connElectric = ConnectionDB::setConnection(new ElectricUUS());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $approve = $connApprove->find(9);
        $elec = $connElectric->find($id);

        $elec->is_updated = '1';
        $elec->catatan = $request->catatan;
        $elec->old_nomor_listrik_awal = $elec->nomor_listrik_awal;
        $elec->old_nomor_listrik_akhir = $elec->nomor_listrik_akhir;
        $elec->old_usage = $elec->usage;
        $elec->nomor_listrik_awal = $request->nomor_listrik_awal;
        $elec->nomor_listrik_akhir = $request->nomor_listrik_akhir;
        $elec->usage = $request->nomor_listrik_akhir - $request->nomor_listrik_awal;
        $elec->save();

        $dataNotif = [
            'models' => 'UpdateElectricRecording',
            'notif_title' => 'Update Utility Usage Recording',
            'id_data' => null,
            'sender' => $request->session()->get('user')->id_user,
            'division_receiver' => null,
            'notif_message' => 'Terjadi kesalahan penginputan meter listrik',
            'receiver' => $approve->approval_3
        ];

        broadcast(new HelloEvent($dataNotif));

        Alert::success('Success', 'Success update data');

        return redirect()->back();
    }

    public function approveUpdate($id)
    {
        $connElectric = ConnectionDB::setConnection(new ElectricUUS());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connRole = ConnectionDB::setConnection(new Role());

        $approve = $connApprove->find(9);
        $role = $connRole->find($approve->approval_1);
        $elec = $connElectric->find($id);

        $elec->is_updated = null;
        $elec->save();

        $dataNotif = [
            'models' => 'UpdateElectricRecording',
            'notif_title' => 'Update Utility Usage Recording',
            'id_data' => null,
            'sender' => $approve->approval_3,
            'division_receiver' => $role->WorkRelation->id_work_relation,
            'notif_message' => 'Perubahan data recording sudah di approve',
            'receiver' => null
        ];

        broadcast(new HelloEvent($dataNotif));

        Alert::success('Success', 'Success update data');

        return redirect()->back();
    }

    public function importElectricUsage(Request $request)
    {
        $file = $request->file_excel;

        Excel::import(new ImportElectric($request), $file);

        Alert::success('Success', 'Success import data');

        return redirect()->back();
    }
}
