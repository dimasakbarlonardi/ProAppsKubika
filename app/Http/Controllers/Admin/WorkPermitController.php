<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\RequestPermit;
use App\Models\System;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Models\WorkPermit;
use App\Models\WorkRelation;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;
use Throwable;

class WorkPermitController extends Controller
{
    public function index(Request $request)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $data['user'] = $request->session()->get('user');
        $data['work_permits'] = $connWP->get();

        return view('AdminSite.WorkPermit.index', $data);
    }

    public function create()
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());

        $data['request_permits'] = $connRP->where('status_request', 'APPROVED')
            ->where('sign_approval_1', '!=', null)
            ->get();

        $data['work_relations'] = $connWorkRelation->get();

        return view('AdminSite.WorkPermit.create', $data);
    }

    public function show(Request $request, $id)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());

        $rp = $connRP->where('id', $id)->with(['tenant', 'ticket', 'rpdetail'])->first();

        $data['user'] = $request->session()->get('user');
        $data['work_relations'] = $connWorkRelation->get();

        if ($request->data_type == 'json') {
            $data['ticket'] = $rp;
            return response()->json(['data' => $rp]);
        } else {
            $wp = $connWP->find($id);
            $data['wp'] = $wp;
            $dataJSON = json_decode($wp->RequestPermit->RPDetail->data);
            $dataJSON = json_decode($dataJSON);
            $data['personels'] = $dataJSON->personels;
            $data['alats'] = $dataJSON->alats;
            $data['materials'] = $dataJSON->materials;

            return view('AdminSite.WorkPermit.show', $data);
        }
    }

    public function store(Request $request)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connSystem = ConnectionDB::setConnection(new System());

        $system = $connSystem->find(1);
        $rp = $connRP->find($request->id_rp);
        $nowDate = Carbon::now();
        $count = $system->sequence_no_po + 1;
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();

            $no_po = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_po . '/' .
                Carbon::now()->format('m') . $nowDate->year . '/' .
                sprintf("%06d", $count);

            $connWP->no_tiket = $rp->no_tiket;
            $connWP->no_request_permit = $rp->no_request_permit;
            $connWP->no_work_permit = $no_po;
            $connWP->nama_project = $request->nama_project;
            $connWP->id_bayarnon = $request->id_bayarnon;
            $connWP->jumlah_deposit = $request->jumlah_deposit;
            $connWP->status_request = 'PENDING';
            $connWP->id_user_work_permit = $user->id_user;
            $connWP->id_work_relation = $request->id_work_relation;
            $connWP->status_bayar = 'PENDING';
            $connWP->save();

            $rp->status_request = 'PROSES';
            $rp->save();

            DB::commit();

            $connNotif = ConnectionDB::setConnection(new Notifikasi());
            $checkNotif = $connNotif->where('models', 'WorkPermit')
                ->where('is_read', 0)
                ->where('id_data', $connWP->id)
                ->first();

            if (!$checkNotif) {
                $connNotif->create([
                    'receiver' => $rp->Ticket->Tenant->User->id_user,
                    'sender' => $user->id_user,
                    'is_read' => 0,
                    'models' => 'WorkPermit',
                    'id_data' => $connWP->id,
                    'notif_title' => $no_po,
                    'notif_message' => 'Work Permit berhasil dibuat, berikut rancangannya'
                ]);
            }

            Alert::success('Berhasil', 'Berhasil membuat Work Permit');

            return redirect()->route('work-permits.index');
        } catch (Throwable $e) {
            DB::rollback();
            dd($e);
            Alert::error('Gagal', 'Gagal membuat Work Permit');
            return redirect()->back();
        }
    }

    public function approveWP1($id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);
        $wp->status_request = 'APPROVED';
        $wp->sign_approval_1 = Carbon::now();
        $wp->save();

        Alert::success('Berjasil', 'Berhasil menerima Work Permit');

        return redirect()->back();
    }

    public function approveWP2(Request $request, $id)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $system = $connSystem->find(1);
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connTransaction = ConnectionDB::setConnection(new Transaction());
        $user = $request->session()->get('user');

        $wp = $connWP->find($id);
        $wp->sign_approval_2 = Carbon::now();
        $wp->save();

        $count = $system->sequence_no_invoice + 1;

        $no_invoice = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $admin_fee = 5000;
        $total = $wp->jumlah_deposit + $admin_fee;

        $createTransaction = $connTransaction;
        $createTransaction->no_invoice = $no_invoice;
        $createTransaction->transaction_type = 'WorkPermit';
        $createTransaction->no_transaction = $wp->no_work_permit;
        $createTransaction->admin_fee = $admin_fee;
        $createTransaction->sub_total = $wp->jumlah_deposit;
        $createTransaction->total = $total;
        $createTransaction->id_user = $wp->Ticket->Tenant->User->id_user;
        $createTransaction->status = 'PENDING';
        $createTransaction->save();

        $ct = $this->transactionCenter($createTransaction);

        $items = [];
        $item = new stdClass();
        $item->id = 1;
        $item->quantity = 1;
        $item->detil_pekerjaan = 'Deposit Work Permit';
        $item->detil_biaya_alat = $wp->jumlah_deposit;
        array_push($items, $item);

        $midtrans = new CreateSnapTokenService($ct, $createTransaction, $items, $admin_fee);

        $ct->snap_token = $midtrans->getSnapToken();
        $ct->save();

        $createTransaction->save();

        $system->sequence_no_invoice = $count;
        $system->save();

        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $checkNotif = $connNotif->where('models', 'Transaction')
            ->where('is_read', 0)
            ->where('id_data', $id)
            ->first();

        if (!$checkNotif) {
            $connNotif->create([
                'receiver' => $wp->Ticket->Tenant->User->id_user,
                'sender' => $user->id_user,
                'is_read' => 0,
                'models' => 'Transaction',
                'id_data' => $createTransaction->id,
                'notif_title' => $createTransaction->no_invoice,
                'notif_message' => 'Work Permit diterima, mohon lakukan pembayaran untuk memulai pekerjaan'
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function transactionCenter($transaction)
    {
        $request = Request();
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();
            $ct = TransactionCenter::create([
                'id_sites' => $user->id_site,
                'no_invoice' => $transaction->no_invoice,
                'transaction_type' => $transaction->transaction_type,
                'no_transaction' => $transaction->no_transaction,
                'admin_fee' => $transaction->admin_fee,
                'sub_total' => $transaction->sub_total,
                'total' => $transaction->total,
                'id_user' => $transaction->id_user,
                'status' => $transaction->status,
            ]);
            DB::commit();

            return $ct;
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }
    }
}
