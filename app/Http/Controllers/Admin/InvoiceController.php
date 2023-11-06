<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CompanySetting;
use App\Models\IPLType;
use App\Models\Utility;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $data['transactions'] = $connCR->get();

        return view('AdminSite.Invoice.index', $data);
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
