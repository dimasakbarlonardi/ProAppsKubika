<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\OtherBill;
use Illuminate\Http\Request;

class OtherBillController extends Controller
{
    public function index()
    {
        $connOtherBill = ConnectionDB::setConnection(new OtherBill());

        $data['list_bills'] = $connOtherBill->get();

        return view('AdminSite.OtherBill.index', $data);
    }

    public function changeActiveStatus($id)
    {
        $connOtherBill = ConnectionDB::setConnection(new OtherBill());

        $bill = $connOtherBill->find($id);

        $bill->is_active = !$bill->is_active;
        $bill->save();

        return response()->json(['status' => $bill->is_active]);
    }

    public function changeRequireVolume($id)
    {
        $connOtherBill = ConnectionDB::setConnection(new OtherBill());

        $bill = $connOtherBill->find($id);

        $bill->is_require_unit_volume = !$bill->is_require_unit_volume;
        $bill->save();

        return response()->json(['status' => $bill->is_require_unit_volume]);
    }
}
