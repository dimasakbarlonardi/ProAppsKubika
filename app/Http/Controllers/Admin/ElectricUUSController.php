<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
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

        $data['elecUSS'] = $connElecUUS->get();

        return view('AdminSite.UtilityUsageRecording.Electric.index', $data);
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
            $transaction = $this->createTransaction($elecUSS);

            $elecUSS->no_refrensi = $transaction->no_reff;
            $elecUSS->save();

            HelpNotifikasi::paymentElecUSS($elecUSS, $transaction);

            Alert::success('Berhasil', 'Berhasil approve WO');

            return redirect()->back();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', $e);
            return redirect()->back();
        }
    }

    public function createTransaction($elecUSS)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $system = $connSystem->find(1);

        $user = $elecUSS->Unit->TenantUnit->Tenant->User;

        $countCR = $system->sequence_no_cash_receiptment + 1;
        $no_cr = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_cash_receipt . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countCR);
        $countINV = $system->sequence_no_invoice + 1;
        $no_inv = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countINV);

        $order_id = $user->id_site . '-' . $no_cr;

        $admin_fee = 5000;

        try {
            DB::beginTransaction();

            $subtotal = $elecUSS->nomor_listrik_akhir - $elecUSS->nomor_listrik_awal;
            $items = [];
            $item = new stdClass();
            $item->id = 1;
            $item->quantity = 1;
            $item->detil_pekerjaan = 'Pembayaran tagihan listrik bulan ' . $elecUSS->periode_bulan;
            $item->detil_biaya_alat = $subtotal;
            array_push($items, $item);

            $createTransaction = $connTransaction;
            $createTransaction->order_id = $order_id;
            $createTransaction->id_site = $user->id_site;
            $createTransaction->no_reff = $no_inv;
            $createTransaction->no_draft_cr = $no_cr;
            $createTransaction->ket_pembayaran = 'INV/' . $user->id_user . '/' . $elecUSS->Unit->nama_unit;
            $createTransaction->admin_fee = $admin_fee;
            $createTransaction->sub_total = $subtotal;
            $createTransaction->gross_amount = $subtotal + $admin_fee;
            $createTransaction->transaction_status = 'PENDING';
            $createTransaction->id_user = $user->id_user;
            $createTransaction->transaction_type = 'ElectricUSS';

            $midtrans = new CreateSnapTokenService($createTransaction, $items);

            $createTransaction->snap_token = $midtrans->getSnapToken();
            $createTransaction->save();

            $system->sequence_no_cash_receiptment = $countCR;
            $system->sequence_no_invoice = $countINV;
            $system->save();


            DB::commit();
        } catch (Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back();
        }

        return $createTransaction;
    }
}
