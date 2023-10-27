<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
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

        $user = $request->session()->get('user');
        $transaction = $connCR->find($id);

        if ($request->session()->get('work_relation_id') != 1 && $request->session()->get('work_relation_id') != 6) {
            if ($user->id_user != $transaction->id_user) {
                return redirect()->back();
            }
        }

        $data['transaction'] = $transaction;

        return view('AdminSite.Invoice.show', $data);
    }
}
