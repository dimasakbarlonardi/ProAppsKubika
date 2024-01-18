<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\SaveFile;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CompanySetting;
use App\Models\Installment;
use App\Models\IPLType;
use App\Models\MonthlyArTenant;
use App\Models\System;
use App\Models\Unit;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class InvoiceController extends Controller
{
    public function index()
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $connUnit = ConnectionDB::setConnection(new Unit());

        $data['transactions'] = $connCR->get();
        $data['units'] = $connUnit->get();

        return view('AdminSite.Invoice.index', $data);
    }

    public function filteredData(Request $request)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $connAR = ConnectionDB::setConnection(new MonthlyArTenant());
        $connSystem = ConnectionDB::setConnection(new CompanySetting());

        $data['system'] = $connSystem->find(1);

        if ($request->type == 'RequestBilling') {
            $transactions = $connCR->where('deleted_at', null)
                ->whereNotIn('transaction_type', ['MonthlyOtherBillTenant', 'MonthlyUtilityTenant', 'MonthlyIPLTenant']);

            if ($request->status != 'all') {
                $transactions = $transactions->where('transaction_status', $request->status);
            }

            $data['transactions'] = $transactions->get();
            $view = view('AdminSite.Invoice.table-data', $data)->render();
        }

        if ($request->type == 'MonthlyBilling') {
            $transactions = $connAR->where('deleted_at', null);

            if ($request->status != 'all') {
                $status = $request->status;
                $transactions = $transactions->whereHas(
                    'UtilityCashReceipt',
                    function ($q) use ($status) {
                        $q->where('transaction_status', $status);
                    }
                )->orWhereHas(
                    'IPLCashReceipt',
                    function ($q) use ($status) {
                        $q->where('transaction_status', $status);
                    }
                );
            }

            if ($request->unit != 'all') {
                $transactions = $transactions->where('id_unit', $request->unit);
            }

            // if ($request->status != 'all') {
            //     $transactions = $transactions->where('transaction_status', $request->status);
            // }

            $data['transactions'] = $transactions->orderBy('id_unit', 'ASC')->get();

            $view = view('AdminSite.Invoice.monthlybill-data', $data)->render();
        }

        return response()->json([
            'html' => $view
        ]);
    }

    public function show(Request $request, $id)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $connSetting = ConnectionDB::setConnection(new CompanySetting());
        $connUtility = ConnectionDB::setConnection(new Utility());
        $connIPLType = ConnectionDB::setConnection(new IPLType());
        $connSetting = ConnectionDB::setConnection(new CompanySetting());

        $user = $request->session()->get('user');
        $transaction = $connCR->find($id);

        if ($request->session()->get('work_relation_id') != 1 && $request->session()->get('work_relation_id') != 6 && $request->session()->get('work_relation_id') != 2) {
            if ($user->id_user != $transaction->id_user) {
                return redirect()->back();
            }
        }

        $data['sc'] = $connIPLType->find(6);
        $data['sf'] = $connIPLType->find(7);
        $data['electric'] = $connUtility->find(1);
        $data['water'] = $connUtility->find(2);
        $data['setting'] = $connSetting->find(1);
        $data['transaction'] = $transaction;
        $data['setting'] = $connSetting->find(1);
        $data['installment'] = [];

        if ($transaction->transaction_type == 'MonthlyTenant' && count($transaction->Installments) > 0) {
            $data['installment'] = $transaction->Installment($transaction->MonthlyARTenant->periode_bulan, $transaction->MonthlyARTenant->periode_tahun);
        }

        return view('AdminSite.Invoice.show', $data);
    }

    public function installment($id)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $data['transaction'] = $connCR->find($id);

        return view('AdminSite.Invoice.installment', $data);
    }

    public function storeInstallment(Request $request, $id)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $connInstallment = ConnectionDB::setConnection(new Installment());
        $connUser = ConnectionDB::setConnection(new User());

        $cr = $connCR->find($id);
        $user = $connUser->where('login_user', $request->user()->email)->first();

        foreach ($request->installments as $i => $item) {
            $connInstallment->create([
                'no_invoice' => $cr->no_invoice,
                'installment_type' => $cr->transaction_type,
                'periode' => $item['period'],
                'tahun' => $item['year'],
                'rev' => 'Rev ' . $i + 1,
                'amount' => $item['jumlah_bayar'],
                'status' => 'PENDING'
            ]);
        }

        $cr->transaction_status = 'PAID';
        $cr->save();

        $dataNotif = [
            'models' => 'Installment',
            'notif_title' => $cr->no_invoice,
            'installment_type' => $cr->transaction_type,
            'id_data' => $cr->id,
            'sender' => $user->id_user,
            'division_receiver' => 2,
            'notif_message' => 'Permintaan Installment invoice',
            'receiver' => null,
            'connection' => ConnectionDB::getDBname()
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function manualPayment(Request $request)
    {
        $connAR = ConnectionDB::setConnection(new MonthlyArTenant());

        $ar = $connAR->find($request->ar_id);
        $fileUtility = $request->file('utility_cash_receipt');
        $fileIPL = $request->file('ipl_cash_receipt');

        if ($fileUtility) {
            $storagePath = SaveFile::saveToStorage($request->user()->id_site, 'manual_payment_utility', $fileUtility);
            $ar->UtilityCashReceipt->payment_image = $storagePath;
            $ar->UtilityCashReceipt->transaction_status = 'PAID';
            $ar->UtilityCashReceipt->settlement_time = Carbon::now();
            $ar->UtilityCashReceipt->payment_type = 'MANUAL';
            $ar->UtilityCashReceipt->save();

            $ar->tgl_bayar_utility = Carbon::now();
        }

        if ($fileIPL) {
            $storagePath = SaveFile::saveToStorage($request->user()->id_site, 'manual_payment_ipl', $fileIPL);
            $ar->IPLCashReceipt->payment_image = $storagePath;
            $ar->IPLCashReceipt->transaction_status = 'PAID';
            $ar->IPLCashReceipt->settlement_time = Carbon::now();
            $ar->IPLCashReceipt->payment_type = 'MANUAL';
            $ar->IPLCashReceipt->save();

            $ar->tgl_bayar_ipl = Carbon::now();
        }

        if ($ar->tgl_bayar_utility && $ar->tgl_bayar_ipl) {
            $ar->status_payment = 'PAID';
        }

        $ar->save();

        Alert::success('Success submit payment');

        return redirect()->back();
    }
}
