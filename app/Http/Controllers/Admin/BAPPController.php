<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\BAPP;
use App\Models\DetailBAPP;
use App\Models\EngBAPP;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\RequestPermit;
use App\Models\System;
use App\Models\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class BAPPController extends Controller
{
    public function index(Request $request)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connBAPP = ConnectionDB::setConnection(new BAPP());

        $data['approve'] = $connApprove->find(5);
        $data['user'] = $request->session()->get('user');
        $data['bapps'] = $connBAPP->get();

        return view('AdminSite.BAPP.index', $data);
    }

    public function create()
    {
        $connTiket = ConnectionDB::setConnection(new OpenTicket());
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connWPS = ConnectionDB::setConnection(new WorkPermit());
        $connEngBAPP = ConnectionDB::setConnection(new EngBAPP());

        $data['engs'] = $connEngBAPP->get();
        $data['tickets'] = $connTiket->get();
        $data['rps'] = $connRP->get();
        $data['wps'] = $connWPS->get();

        return view('AdminSite.BAPP.create', $data);
    }

    public function store(Request $request)
    {
        $connBAPP = ConnectionDB::setConnection(new BAPP());
        $connSystem = ConnectionDB::setConnection(new System());
        $connDetailBAPP = ConnectionDB::setConnection(new DetailBAPP());

        $system = $connSystem->find(1);
        $count = $system->sequence_no_bapp + 1;

        $no_bapp = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $connDetailBAPP->create([
            'no_bapp' => $no_bapp,
            'id_eng_bapp' => json_encode($request->detail_bapp),
            'keterangan' => $request->keterangan
        ]);

        $connBAPP->create([
            'no_tiket' => $request->no_tiket,
            'no_request_permit' => $request->no_request_permit,
            'no_work_permit' => $request->no_work_permit,
            'no_bapp' => $no_bapp,
            'tgl_penyelesaian' => $request->tanggal_penyelesaian,
            'jumlah_deposit' => $request->jumlah_deposit,
            'jumlah_potongan' => $request->jumlah_potongan,
            'jumlah_kembali_deposit' => $request->jumlah_kembali_deposit,
            'bank_pemohon' => $request->bank_pemohon,
            'nama_rek_pemohon' => $request->nama_rek_pemohon,
            'rek_pemohon' => $request->rek_pemohon,
            'status_pengembalian' => 0
        ]);

        $system->sequence_no_bapp = $count;
        $system->save();

        Alert::success('Berhasil', 'Berhasil membuat BAPP');

        return redirect()->route('bapp.index');
    }

    public function doneTF(Request $request, $id)
    {
        $connBAPP = ConnectionDB::setConnection(new BAPP());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $bapp = $connBAPP->find($id);
        $bapp->status_pengembalian = 1;
        $bapp->save();
        $user = $request->session()->get('user');

        $checkNotif = $connNotif->where('models', 'BAPP')
            ->where('is_read', 0)
            ->where('id_data', $id)
            ->first();

        if (!$checkNotif) {
            $connNotif->create([
                'receiver' => $bapp->Ticket->Tenant->User->id_user,
                'sender' => $user->id_user,
                'is_read' => 0,
                'models' => 'BAPP',
                'id_data' => $id,
                'notif_title' => $bapp->no_bapp,
                'notif_message' => 'Deposit sudah dikembalikan, mohon periksa kembali dan approve'
            ]);
        }

        Alert::success('Berhasil', 'Berhasil mengupdate BAPP');

        return redirect()->back();
    }

    public function bappApprove1($id)
    {
        $connBAPP = ConnectionDB::setConnection(new BAPP());

        $bapp = $connBAPP->find($id);
        $bapp->sign_approval_1 = Carbon::now();
        $bapp->save();
        $bapp->WorkPermit->status_request = 'DONE';
        $bapp->WorkPermit->save();
        $bapp->RequestPermit->status_request = 'DONE';
        $bapp->RequestPermit->save();
        $bapp->Ticket->status_request = 'DONE';
        $bapp->Ticket->save();

        Alert::success('Berhasil', 'Berhasil mengupdate BAPP');

        return redirect()->back();
    }

    public function bappApprove2($id)
    {
        $connBAPP = ConnectionDB::setConnection(new BAPP());

        $bapp = $connBAPP->find($id);
        $bapp->sign_approval_2 = Carbon::now();
        $bapp->save();

        Alert::success('Berhasil', 'Berhasil mengupdate BAPP');

        return redirect()->back();
    }

    public function bappApprove3($id)
    {
        $connBAPP = ConnectionDB::setConnection(new BAPP());

        $bapp = $connBAPP->find($id);
        $bapp->sign_approval_3 = Carbon::now();
        $bapp->save();

        Alert::success('Berhasil', 'Berhasil mengupdate BAPP');

        return redirect()->back();
    }

    public function bappApprove4($id)
    {
        $connBAPP = ConnectionDB::setConnection(new BAPP());

        $bapp = $connBAPP->find($id);
        $bapp->sign_approval_4 = Carbon::now();
        $bapp->save();
        $bapp->WorkPermit->status_request = 'COMPLETE';
        $bapp->WorkPermit->save();
        $bapp->RequestPermit->status_request = 'COMPLETE';
        $bapp->RequestPermit->save();
        $bapp->Ticket->status_request = 'COMPLETE';
        $bapp->Ticket->save();

        Alert::success('Berhasil', 'Berhasil mengupdate BAPP');

        return redirect()->back();
    }
}
