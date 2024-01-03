<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\MonthlyArTenant;
use Illuminate\Http\Request;

class SPController extends Controller
{
    public function index()
    {
        $ar = ConnectionDB::setConnection(new MonthlyArTenant());

        $data['invoices'] = $ar->where('sp1', true)->get();

        return view('AdminSite.SP1.indexSP1', $data);
    }

    public function template()
    {
        return view('AdminSite.SP.template');
    }

    public function blast(Request $request)
    {
        $condition = '!$ar->NotifSP1($ar->Unit->nama_unit)';
        $notifMessage = 'Surat Peringatan 1';
        $this->blastSP($request, $condition, $notifMessage);

        return response()->json(['status' => 'ok']);
    }

    public function sp2()
    {
        $ar = ConnectionDB::setConnection(new MonthlyArTenant());

        $data['invoices'] = $ar->where('sp2', true)->get();

        return view('AdminSite.SP1.indexSP2', $data);
    }

    public function blastSP2(Request $request)
    {
        $connAR = ConnectionDB::setConnection(new MonthlyArTenant());

        foreach ($request->IDs as $id) {
            $ar = $connAR->find($id);
            $ar = $ar->LastBill();

            if (!$ar->NotifSP2($ar->Unit->nama_unit)) {
                $dataNotif = [
                    'models' => 'SP',
                    'notif_title' => $ar->Unit->nama_unit,
                    'id_data' => $ar->id_monthly_ar_tenant,
                    'sender' => $request->session()->get('user')->id_user,
                    'division_receiver' => null,
                    'notif_message' => 'Surat Peringatan 2',
                    'receiver' => $ar->Unit->Owner()->Tenant->User->id_user,
                    'connection' => ConnectionDB::getDBname()
                ];

                broadcast(new HelloEvent($dataNotif));
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function sp3()
    {
        $ar = ConnectionDB::setConnection(new MonthlyArTenant());

        $data['invoices'] = $ar->where('sp3', true)->get();

        return view('AdminSite.SP1.indexSP3', $data);
    }

    public function blastSP3(Request $request)
    {
        $condition = '!$ar->NotifSP3($ar->Unit->nama_unit)';
        $notifMessage = 'Surat Peringatan 3';
        $this->blastSP($request, $condition, $notifMessage);

        return response()->json(['status' => 'ok']);
    }

    public function spFinal()
    {
        $ar = ConnectionDB::setConnection(new MonthlyArTenant());

        $data['invoices'] = $ar->where('final_warning', true)->get();

        return view('AdminSite.SP1.indexSPFinal', $data);
    }

    public function blastSPFinal(Request $request)
    {
        $condition = '!$ar->NotifSPFinal($ar->Unit->nama_unit)';
        $notifMessage = 'Surat Pemberitahuan Terakhir';
        $this->blastSP($request, $condition, $notifMessage);

        return response()->json(['status' => 'ok']);
    }

    function blastSP($request, $condition, $notifMessage)
    {
        $connAR = ConnectionDB::setConnection(new MonthlyArTenant());

        foreach ($request->IDs as $id) {
            $ar = $connAR->find($id);
            $ar = $ar->LastBill();
            if ($condition) {
                $dataNotif = [
                    'models' => 'SP',
                    'notif_title' => $ar->Unit->nama_unit,
                    'id_data' => $ar->id_monthly_ar_tenant,
                    'sender' => $request->session()->get('user')->id_user,
                    'division_receiver' => null,
                    'notif_message' => $notifMessage,
                    'receiver' => $ar->Unit->Owner()->Tenant->User->id_user,
                    'connection' => ConnectionDB::getDBname()
                ];

                broadcast(new HelloEvent($dataNotif));
            }
        }
    }
}
