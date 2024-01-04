<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CompanySetting;
use App\Models\Installment;
use App\Models\IPLType;
use App\Models\MonthlyArTenant;
use App\Models\Unit;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;

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

        if ($request->type == 'RequestBilling') {
            $transactions = $connCR->where('deleted_at', null);

            if ($request->status != 'all') {
                $transactions = $transactions->where('transaction_status', $request->status);
            }

            $data['transactions'] = $transactions->get();
            $view = view('AdminSite.Invoice.table-data', $data)->render();
        }

        if ($request->type == 'MonthlyBilling') {
            $transactions = $connAR->where('deleted_at', null);

            if ($request->status != 'all') {
                $transactions = $transactions->where('transaction_status', $request->status);
            }

            // dd($transactions->get());
            $data['transactions'] = $transactions->get();
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
}
