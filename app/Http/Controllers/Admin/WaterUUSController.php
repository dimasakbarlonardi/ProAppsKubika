<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Site;
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
        $connUnit = ConnectionDB::setConnection(new Unit());

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
        $data['units'] = $connUnit->get();

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
                $waterUSS = $connWaterUUS->find($id);

                $waterUSS->is_approve = '1';
                $waterUSS->save();

                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                dd($e);
                return response()->json(['status' => 'failed']);
            }
        }
        return response()->json(['status' => 'ok']);
    }
}
