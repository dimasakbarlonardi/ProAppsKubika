<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CashReceiptDetail;
use App\Models\ElectricUUS;
use App\Models\Site;
use App\Models\System;
use App\Models\Unit;
use App\Models\User;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;
use Throwable;

class ElectricUUSController extends Controller
{
    public function index()
    {
        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());
        $connUnit = ConnectionDB::setConnection(new Unit());

        $data['units'] = $connUnit->get();
        $data['elecUSS'] = $connElecUUS->get();

        return view('AdminSite.UtilityUsageRecording.Electric.index', $data);
    }

    public function getRecords(Request $request)
    {
        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());

        if ($request->status == 'PENDING') {
            $record = $connElecUUS->where('is_approve', "");
        } else {
            $record = $connElecUUS;
        }

        $data['elecUSS'] = $record->get();

        return response()->json([
            'table' => view('AdminSite.UtilityUsageRecording.Electric.table', $data)->render()
        ]);
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

    public function approve($id)
    {
        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());
        $elecUSS = $connElecUUS->find($id);

        try {
            DB::beginTransaction();

            $elecUSS->is_approve = '1';
            $elecUSS->save();

            // HelpNotifikasi::paymentElecUSS($elecUSS, $transaction);

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
