<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\MonthlyArTenant;
use Illuminate\Http\Request;

class SP1Controller extends Controller
{
    public function index()
    {
        $ar = ConnectionDB::setConnection(new MonthlyArTenant());

        $data['invoices'] = $ar->where('sp1', true)->where('tgl_bayar_invoice', null)->get();

        return view('AdminSite.SP1.index', $data);
    }

    public function blast(Request $request)
    {
        $connAR = ConnectionDB::setConnection(new MonthlyArTenant());

        foreach ($request->IDs as $id) {
            $ar = $connAR->find($id);
            $ar = $ar->LastBill();
            if (!$ar->NotifSP1($ar->Unit->nama_unit)) {
                $dataNotif = [
                    'models' => 'SP1',
                    'notif_title' => $ar->Unit->nama_unit,
                    'id_data' => $ar->id_monthly_ar_tenant,
                    'sender' => $request->session()->get('user')->id_user,
                    'division_receiver' => null,
                    'notif_message' => 'Surat peringatan 1',
                    'receiver' => $ar->Unit->Owner()->Tenant->User->id_user,
                ];

                broadcast(new HelloEvent($dataNotif));
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
