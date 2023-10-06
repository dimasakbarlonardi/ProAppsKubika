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

    public function show($id)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $data['transaction'] = $connCR->find($id);

        return view('AdminSite.Invoice.show', $data);
    }
}
