<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\BAPP;
use App\Models\CashReceipt;
use App\Models\CompanySetting;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\RequestPermit;
use App\Models\Site;
use App\Models\System;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Models\WorkPermit;
use App\Models\WorkPriority;
use App\Models\WorkRelation;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use PDF;
use stdClass;
use Throwable;

class WorkPermitController extends Controller
{
    public function index(Request $request)
    {
        $connWorkPrior = ConnectionDB::setConnection(new WorkPriority());

        $data['user'] = $request->session()->get('user');
        $data['priorities'] = $connWorkPrior->get();

        return view('AdminSite.WorkPermit.index', $data);
    }

    public function filteredData(Request $request)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $permits = $connWP->where('deleted_at', null);

        if ($request->valueString) {
            $valueString = $request->valueString;
            $permits = $permits->whereHas('Ticket.Tenant', function ($q) use ($valueString) {
                $q->where('nama_tenant', 'like', '%' . $valueString . '%');
            })->orWhere('no_work_permit', 'like', '%' . $valueString . '%');
        }

        if ($request->status != 'all') {
            $permits = $permits->where('status_request', $request->status);
        }
        if ($request->priority != 'all') {
            $priority = $request->priority;
            $permits = $permits->whereHas('Ticket', function ($q) use ($priority) {
                $q->where('priority', $priority);
            });
        }

        $permits = $permits->orderBy('no_work_permit', 'desc');

        $data['work_permits'] = $permits->get();

        return response()->json([
            'html' => view('AdminSite.WorkPermit.table-data', $data)->render()
        ]);
    }

    public function create(Request $request)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());

        $data['request_permits'] = $connRP->where('status_request', 'APPROVED')
            ->where('sign_approval_1', '!=', null)
            ->get();

        $data['request_permit'] = $connRP->find($request->id_rp);
        $data['work_relations'] = $connWorkRelation->get();
        $data['id_rp'] = $request->id_rp;

        return view('AdminSite.WorkPermit.create', $data);
    }

    public function show(Request $request, $id)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $rp = $connRP->where('id', $id)->with(['tenant', 'ticket', 'rpdetail'])->first();

        $data['approve'] = $connApprove->find(5);
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
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connSystem = ConnectionDB::setConnection(new System());

        $system = $connSystem->find(1);
        $ticket = $connTicket->find($request->no_tiket);

        $nowDate = Carbon::now();
        $count = $system->sequence_no_po + 1;
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();

            $no_po = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_po . '/' .
                Carbon::now()->format('m') . $nowDate->year . '/' .
                sprintf("%06d", $count);

            $connWP->no_tiket = $ticket->no_tiket;
            $connWP->no_request_permit = $ticket->RequestPermit->no_request_permit;
            $connWP->no_work_permit = $no_po;
            $connWP->id_bayarnon = 1;
            $connWP->jumlah_supervisi = $request->jumlah_supervisi;
            $connWP->jumlah_deposit = $request->jumlah_deposit;
            $connWP->status_request = 'PENDING';
            $connWP->id_user_work_permit = $user->id_user;
            $connWP->id_work_relation = $request->id_work_relation;
            $connWP->status_bayar = 'PENDING';
            $connWP->save();

            $ticket->RequestPermit->status_request = 'PROSES';
            $ticket->RequestPermit->sign_approval_1 = $nowDate;
            $ticket->RequestPermit->save();

            $ticket->status_request = 'PROSES';
            $ticket->save();

            $system->sequence_no_po = $count;
            $system->save();

            DB::commit();

            $dataNotif = [
                'models' => 'WorkPermit',
                'notif_title' => $no_po,
                'id_data' => $connWP->id,
                'sender' => $user->id_user,
                'division_receiver' => null,
                'notif_message' => 'Work Permit berhasil dibuat, berikut rancangannya',
                'receiver' => $ticket->Tenant->User->id_user
            ];

            broadcast(new HelloEvent($dataNotif));

            return response()->json(['status' => 'ok']);
        } catch (Throwable $e) {
            DB::rollback();
            dd($e);
            Alert::error('Gagal', 'Gagal membuat Work Permit');
            return redirect()->back();
        }
    }

    public function rejectWP(Request $request, $id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);

        $wp->Ticket->status_request = 'REJECTED';
        $wp->Ticket->save();

        $wp->RequestPermit->status_request = 'REJECTED';
        $wp->RequestPermit->save();

        $wp->status_request = 'REJECTED';
        $wp->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $wp->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => 1,
            'notif_message' => 'Maaf work permit saya tolak, terima kasih..',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function approveWP1(Request $request, $id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);

        $wp->status_request = 'APPROVED';
        $wp->sign_approval_1 = Carbon::now();
        $wp->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $wp->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => $wp->id_work_relation,
            'notif_message' => 'Work Permit diterima, mohon diproses lebih lanjut. Terima kasih..',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function approveWP2(Request $request, $id)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);
        $wp->sign_approval_2 = Carbon::now();
        $approve = $connApprove->find(5);

        $wp->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $wp->id,
            'sender' => $request->session()->get('user')->id_user,
            'division_receiver' => null,
            'notif_message' => 'Work Permit diterima, mohon diproses lebih lanjut',
            'receiver' => $approve->approval_3,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function approveWP3($id, Request $request)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $connSystem = ConnectionDB::setConnection(new System());

        $system = $connSystem->find(1);
        $user = $request->session()->get('user');

        $countCR = $system->sequence_no_cash_receiptment + 1;
        $no_cr = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_cash_receipt . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countCR);

        $count = $system->sequence_no_invoice + 1;
        $no_invoice = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $order_id = $user->id_site . '-' . $no_cr;

        $wp = $connWP->find($id);

        if (!$wp->CashReceipt) {
            $createTransaction = $connTransaction;
            $createTransaction->order_id = $order_id;
            $createTransaction->id_site = $user->id_site;
            $createTransaction->no_reff = $wp->no_work_permit;
            $createTransaction->no_invoice = $no_invoice;
            $createTransaction->no_draft_cr = $no_cr;
            $createTransaction->ket_pembayaran = 'INV/' . $user->id_user . '/' . $wp->Ticket->Unit->nama_unit;
            $createTransaction->sub_total = $wp->jumlah_deposit + $wp->jumlah_supervisi;
            $createTransaction->transaction_status = 'PENDING';
            $createTransaction->id_user = $wp->Ticket->Tenant->User->id_user;
            $createTransaction->transaction_type = 'WorkPermit';

            $wp->Ticket->no_invoice = $no_invoice;
            $wp->Ticket->save();

            $createTransaction->save();

            $system->sequence_no_invoice = $count;
            $system->sequence_no_cash_receiptment = $countCR;
            $system->save();
        }

        $wp->sign_approval_3 = Carbon::now();
        $wp->save();

        $approve = $connApprove->find(5);
        $dataNotif = [
            'models' => 'paymentPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $wp->CashReceipt->id,
            'sender' => $approve->approval_3,
            'division_receiver' => null,
            'notif_message' => 'Work Permit diapprove, mohon melakukan pembayaran untuk proses lebih lanjut',
            'receiver' => $wp->Ticket->Tenant->User->id_user,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function approveWP4(Request $request, $id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);
        $wp->sign_approval_4 = Carbon::now();
        $wp->generateBarcode();
        $wp->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => $wp->id_work_relation,
            'notif_message' => 'Work Permit diterima, selamat bekerja',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        $dataNotifIzinKerja = [
            'models' => 'IzinKerja',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $wp->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => 1,
            'notif_message' => 'Work Permit diterima, berikut surat izin kerja permit',
            'receiver' => $wp->Ticket->Tenant->User->id_user
        ];

        broadcast(new HelloEvent($dataNotifIzinKerja));

        return response()->json(['status' => 'ok']);
    }

    public function workDoneWP(Request $request, $id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);
        $wp->status_request = 'WORK DONE';
        $wp->is_worked = 1;
        $wp->save();

        $wp->RequestPermit->status_request = 'WORK DONE';
        $wp->RequestPermit->save();

        $wp->Ticket->status_request = 'WORK DONE';
        $wp->Ticket->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => null,
            'notif_message' => 'Work Permit selesai dikerjakan, mohon periksa kembali. Terima kasih..',
            'receiver' => $wp->Ticket->Tenant->User->id_user,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function doneWP(Request $request, $id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);
        $wp->status_request = 'COMPLETE';
        $wp->is_done = true;
        $wp->save();

        $wp->RequestPermit->status_request = 'COMPLETE';
        $wp->RequestPermit->save();

        $wp->Ticket->status_request = 'COMPLETE';
        $wp->Ticket->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => 1,
            'notif_message' => 'Work Permit telah selesai, terima kasih.',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function generatePaymentPO(Request $request, $cr)
    {
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $user = $request->session()->get('user');
        $site = Site::find($user->id_site);

        $transaction = $connTransaction->find($cr);

        $client = new Client();
        $billing = explode(',', $request->billing);
        $admin_fee = $request->admin_fee;

        $transaction->gross_amount = $transaction->sub_total + $admin_fee;
        $transaction->payment_type = 'bank_transfer';
        $transaction->bank = Str::upper($billing[1]);

        $payment = [];

        $payment['payment_type'] = $billing[0];
        $payment['transaction_details']['order_id'] = $transaction->order_id;
        $payment['transaction_details']['gross_amount'] = $transaction->gross_amount;
        $payment['bank_transfer']['bank'] = $billing[1];

        $response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/charge', [
            'body' => json_encode($payment),
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . base64_encode($site->midtrans_server_key),
                'content-type' => 'application/json',
            ],
            "custom_expiry" => [
                "order_time" => Carbon::now(),
                "expiry_duration" => 1,
                "unit" => "day"
            ]
        ]);
        $response = json_decode($response->getBody());

        if ($response->status_code == 201) {
            $transaction->va_number = $response->va_numbers[0]->va_number;
            $transaction->expiry_time = $response->expiry_time;
            $transaction->admin_fee = $admin_fee;
            $transaction->transaction_status = 'VERIFYING';
            $transaction->save();

            return redirect()->route('paymentMonthly', [$transaction->WorkPermit->id, $transaction->id]);
        } else {
            Alert::info('Sorry', 'Our server is busy');
            return redirect()->back();
        }
    }

    public function paymentPO($id)
    {
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());

        $data['transaction'] = $connTransaction->find($id);

        return view('Tenant.Notification.Invoice.payment-monthly', $data);
    }

    public function printWP($id, $idSite)
    {
        $site = Site::find($idSite);
        $model = new WorkPermit();
        $modelSetting = new CompanySetting();

        $connWP = $model->setConnection($site->db_name);
        $connSetting = $modelSetting->setConnection($site->db_name);

        $data['wp'] = $connWP->find($id);
        $data['setting'] = $connSetting->find(1);

        return view('AdminSite.WorkPermit.printout', $data);
    }
}
