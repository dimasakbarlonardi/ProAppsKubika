<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\Role;
use App\Models\Site;
use App\Models\Tower;
use App\Models\Unit;
use App\Models\User;
use App\Models\WaterUUS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class WaterUUSController extends Controller
{
    public function index(Request $request)
    {
        $connWatercUUS = ConnectionDB::setConnection(new WaterUUS());
        $connTower = ConnectionDB::setConnection(new Tower());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $data['approve'] = $connApprove->find(9);
        $data['user'] = $request->session()->get('user');

        switch ($request->status) {
            case ('PENDING'):
                $record = $connWatercUUS->where('is_approve', null)
                    ->where('id_unit', $request->id_unit);
                break;
            case ('APPROVED'):
                $record = $connWatercUUS->where('is_approve', "1")
                    ->where('no_refrensi', null)
                    ->where('id_unit', $request->id_unit);
                break;
            case ('WAITING'):
                $record = $connWatercUUS->where('is_approve', "1")
                    ->where('no_refrensi', '!=', null)
                    ->where('id_unit', $request->id_unit)
                    ->whereHas('MonthlyUtility.MonthlyTenant', function ($query) {
                        $query->where('tgl_jt_invoice', null);
                    })
                    ->with('MonthlyUtility.MonthlyTenant');
                break;
            case ('PAYED'):
                $record = $connWatercUUS->where('id_unit', $request->id_unit)
                    ->whereHas('MonthlyUtility.MonthlyTenant', function ($query) {
                        $query->where('tgl_bayar_invoice', '!=', null);
                    })
                    ->with('MonthlyUtility.MonthlyTenant');
                break;

            case ('UNPAID'):
                $record = $connWatercUUS->where('id_unit', $request->id_unit)
                    ->whereHas('MonthlyUtility.MonthlyTenant', function ($query) {
                        $query->where('tgl_bayar_invoice', null);
                        $query->where('tgl_jt_invoice', '!=', '');
                    })
                    ->with('MonthlyUtility.MonthlyTenant');
                break;
            default:
                $record = $connWatercUUS;
                break;
        }

        $data['waterUSS'] = $record->get();
        $data['towers'] = $connTower->get();

        return view('AdminSite.UtilityUsageRecording.Water.index', $data);
    }

    public function create()
    {
        $id_unit = '0042120104';

        $connUnit = ConnectionDB::setConnection(new Unit());
        $unit = $connUnit->where('id_unit', $id_unit)->first();

        if ($unit->allWaterUUSbyYear) {
            $monthUUS = [];
            foreach ($unit->allWaterUUSbyYear as $uus) {
                $monthUUS[] = $uus->periode_bulan;
            }
        }

        $data['unit'] = $unit;
        $data['monthUUS'] = $monthUUS;

        return view('AdminSite.UtilityUsageRecording.Water.create', $data);
    }

    public function store($id_unit, Request $request)
    {
        $site = Site::find($request->user()->id_site);
        $user = new User();
        $user = $user->setConnection($site->db_name);
        $user = $user->where('login_user', $request->user()->email)->first();

        $connWaterUUS = ConnectionDB::setConnection(new WaterUUS());

        $connWaterUUS->create([
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => Carbon::now()->format('Y'),
            'id_unit' => $id_unit,
            'nomor_air_awal' => $request->previous,
            'nomor_air_akhir' => $request->current,
            'usage' => $request->current - $request->previous,
            'id_user' => $user->id_user
        ]);

        Alert::success('Berhasil', 'Berhasil menambahkan data');

        return redirect()->back();
    }

    public function approve(Request $request)
    {
        $connWaterUUS = ConnectionDB::setConnection(new WaterUUS());
        foreach($request->IDs as $id) {
            try {
                DB::beginTransaction();
                $waterUSS = $connWaterUUS->where('id', $id)
                ->where('is_updated', null)
                ->first();

                if ($waterUSS) {
                    $waterUSS->is_approve = '1';
                    $waterUSS->save();

                    DB::commit();
                }
            } catch (Throwable $e) {
                DB::rollBack();
                dd($e);
                return response()->json(['status' => 'failed']);
            }
        }
        return response()->json(['status' => 'ok']);
    }

    public function update(Request $request, $id)
    {
        $connWater = ConnectionDB::setConnection(new WaterUUS());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $approve = $connApprove->find(9);
        $water = $connWater->find($id);

        $water->is_updated = '1';
        $water->catatan = $request->catatan;
        $water->old_nomor_air_awal = $water->nomor_air_awal;
        $water->old_nomor_air_akhir = $water->nomor_air_akhir;
        $water->old_usage = $water->usage;
        $water->nomor_air_awal = $request->nomor_air_awal;
        $water->nomor_air_akhir = $request->nomor_air_akhir;
        $water->usage = $request->nomor_air_akhir - $request->nomor_air_awal;
        $water->save();

        $dataNotif = [
            'models' => 'UpdateWaterRecording',
            'notif_title' => 'Update Utility Usage Recording',
            'id_data' => null,
            'sender' => $request->session()->get('user')->id_user,
            'division_receiver' => null,
            'notif_message' => 'Terjadi kesalahan penginputan meter air',
            'receiver' => $approve->approval_3
        ];

        broadcast(new HelloEvent($dataNotif));

        Alert::success('Success', 'Success update data');

        return redirect()->back();
    }

    public function approveUpdate($id)
    {
        $connWater = ConnectionDB::setConnection(new WaterUUS());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connRole = ConnectionDB::setConnection(new Role());

        $approve = $connApprove->find(9);
        $water = $connWater->find($id);
        $role = $connRole->find($approve->approval_1);

        $water->is_updated = null;
        $water->save();

        $dataNotif = [
            'models' => 'UpdateWaterRecording',
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
}
