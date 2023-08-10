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
    public function index()
    {
        $connWatercUUS = ConnectionDB::setConnection(new WaterUUS());

        $data['waterUSS'] = $connWatercUUS->get();

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

    public function approve($id)
    {
        $connWaterUUS = ConnectionDB::setConnection(new WaterUUS());
        $waterUSS = $connWaterUUS->find($id);

        try {
            DB::beginTransaction();

            $waterUSS->is_approve = '1';
            $waterUSS->save();

            Alert::success('Berhasil', 'Berhasil approve tagihan');

            return redirect()->back();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', $e);
            return redirect()->back();
        }
    }
}
