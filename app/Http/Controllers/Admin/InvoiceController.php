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

        // dd($data);
        return view('AdminSite.Invoice.index', $data);
    }
}
