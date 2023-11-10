<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CompanySetting;
use App\Models\IPLType;
use App\Models\Unit;
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

        $transactions = $connCR->where('deleted_at', null);

        if ($request->status != 'all') {
            $transactions = $transactions->where('transaction_status', $request->status);
        }

        $data['transactions'] = $transactions->get();

        return response()->json([
            'html' => view('AdminSite.Invoice.table-data', $data)->render()
        ]);
    }

    public function show(Request $request, $id)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $connSetting = ConnectionDB::setConnection(new CompanySetting());
        $connUtility = ConnectionDB::setConnection(new Utility());
        $connIPLType = ConnectionDB::setConnection(new IPLType());

        $user = $request->session()->get('user');
        $transaction = $connCR->find($id);

        if ($request->session()->get('work_relation_id') != 1 && $request->session()->get('work_relation_id') != 6) {
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

        return view('AdminSite.Invoice.show', $data);
    }
}
