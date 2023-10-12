<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\CashReceipt;
use App\Models\JenisAcara;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\Reservation;
use App\Models\RuangReservation;
use App\Models\Site;
use App\Models\System;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Models\TypeReservation;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\CoreApi;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;
use Throwable;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $connReqRev = ConnectionDB::setConnection(new Reservation());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $data['user'] = $request->session()->get('user');
        $data['approve'] = $connApprove->find(7);
        $data['reservations'] = $connReqRev->get();

        return view('AdminSite.RequestReservation.index', $data);
    }

    public function getBookedDate(Request $request)
    {
        $startdate = $request->startdate;
        $startdatetime = $request->startdatetime;
        $enddatetime = $request->enddatetime;
        $enddate = $request->enddate;

        $connReqRev = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReqRev->whereDate('waktu_mulai', $startdate)
            ->whereBetween('waktu_mulai', [$startdatetime, $enddatetime])
            ->orWhereBetween('waktu_akhir', [$startdatetime, $enddatetime])
            ->get(['id', 'waktu_mulai', 'waktu_akhir']);

        return response()->json(['data' => $rsv]);
    }

    public function create()
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connTypeRsv = ConnectionDB::setConnection(new TypeReservation());
        $connRuangRsv = ConnectionDB::setConnection(new RuangReservation());
        $connJenisAcara = ConnectionDB::setConnection(new JenisAcara());

        $data['typeRsv'] = $connTypeRsv->get();
        $data['ruangRsv'] = $connRuangRsv->get();
        $data['jenisAcara'] = $connJenisAcara->get();
        $data['tickets'] = $connTicket->where('status_request', 'PROSES KE RESERVASI')->get();

        return view('AdminSite.RequestReservation.create', $data);
    }

    public function store(Request $request)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connSystem = ConnectionDB::setConnection(new System());
        $user = $request->session()->get('user');

        $waktu_mulai = $request->tgl_request_reservation . ' ' . $request->waktu_mulai;
        $waktu_akhir = $request->tgl_request_reservation . ' ' . $request->waktu_akhir;

        try {
            DB::beginTransaction();

            $system = $connSystem->find(1);
            $ticket = $connTicket->find($request->no_tiket);
            $count = $system->sequence_no_reservation + 1;

            $no_reservation = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_reservation . '/' .
                Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
                sprintf("%06d", $count);

            $createRsv = $connReservation->create([
                'no_tiket' => $ticket->no_tiket,
                'no_request_reservation' => $no_reservation,
                'tgl_request_reservation' => $request->tgl_request_reservation,
                'id_type_reservation' => $request->id_type_reservation,
                'id_ruang_reservation' => $request->id_ruang_reservation,
                'id_jenis_acara' => $request->id_jenis_acara,
                'keterangan' => $request->keterangan,
                'durasi_acara' => $request->durasi_acara . ' ' . $request->satuan_durasi_acara,
                'waktu_mulai' => $waktu_mulai,
                'waktu_akhir' => $waktu_akhir,
                'is_deposit' => $request->is_deposit,
                'jumlah_deposit' => $request->jumlah_deposit,
                'status_bayar' => 'PENDING',
            ]);

            $ticket->status_request = 'PROSES';
            $ticket->save();

            $dataNotif = [
                'models' => 'Reservation',
                'notif_title' => $createRsv->no_request_reservation,
                'id_data' => $createRsv->id,
                'sender' => $user->id_user,
                'division_receiver' => null,
                'notif_message' => 'Request Reservation diterima, mohon approve reservasi',
                'receiver' => $ticket->Tenant->User->id_user,
            ];

            broadcast(new HelloEvent($dataNotif));

            $system->sequence_no_reservation = $count;
            $system->save();

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan request');

            return redirect()->route('request-reservations.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);
        $data['reservation'] = $rsv;

        return view('AdminSite.RequestReservation.show', $data);
    }

    public function reject($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);

        $rsv->Ticket->status_request = 'REJECTED';
        $rsv->Ticket->save();

        Alert::success('Berhasil', 'Success reject reservation');

        return redirect()->back();
    }

    public function approve1(Request $request, $id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $user = $request->session()->get('user');

        $rsv = $connReservation->find($id);

        $rsv->sign_approval_1 = Carbon::now();
        $rsv->save();

        $dataNotif = [
            'models' => 'Reservation',
            'notif_title' => $rsv->no_request_reservation,
            'id_data' => $rsv->id,
            'sender' => $user->id_user,
            'division_receiver' => 10,
            'notif_message' => 'Request Reservation diterima, mohon approve reservasi',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        Alert::success('Berhasil', 'Berhasil approve reservasi');

        return redirect()->back();
    }

    public function approve2(Request $request, $id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $rsv = $connReservation->find($id);
        $system = $connSystem->find(1);
        $count = $system->sequence_no_invoice + 1;
        $approve = $connApprove->find(7);
        $user = $rsv->Ticket->Tenant->User;

        $no_invoice = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $countCR = $system->sequence_no_cash_receiptment + 1;
        $no_cr = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_cash_receipt . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countCR);

        $order_id = $user->id_site . '-' . $no_cr;

        try {
            DB::beginTransaction();

            if ($rsv->is_deposit) {
                $createTransaction = $connTransaction;
                $createTransaction->order_id = $order_id;
                $createTransaction->id_site = $user->id_site;
                $createTransaction->no_reff = $rsv->no_request_reservation;
                $createTransaction->no_invoice = $no_invoice;
                $createTransaction->no_draft_cr = $no_cr;
                $createTransaction->ket_pembayaran = 'INV/' . $user->id_user . '/' . $rsv->Ticket->Unit->nama_unit;
                $createTransaction->sub_total = $rsv->jumlah_deposit;
                $createTransaction->transaction_status = 'PENDING';
                $createTransaction->id_user = $user->id_user;
                $createTransaction->transaction_type = 'Reservation';
                $createTransaction->save();

                $system->sequence_no_cash_receiptment = $countCR;
                $system->sequence_no_invoice = $count;
                $system->save();

                $dataNotif = [
                    'models' => 'PaymentReservation',
                    'notif_title' => $createTransaction->no_invoice,
                    'id_data' => $rsv->id,
                    'sender' => $approve->approval_3,
                    'division_receiver' => null,
                    'notif_message' => 'Request Reservation diterima, mohon membayar deposit untuk melanjutkan proses reservasi',
                    'receiver' => $rsv->Ticket->Tenant->User->id_user,
                ];

                broadcast(new HelloEvent($dataNotif));
            } else {
                $dataNotif = [
                    'models' => 'Reservation',
                    'notif_title' => $rsv->no_request_reservation,
                    'id_data' => $rsv->id,
                    'sender' => $request->session()->get('user')->id_user,
                    'division_receiver' => null,
                    'notif_message' => 'Request Reservation diterima, mohon approve reservasi',
                    'receiver' => $rsv->Ticket->Tenant->User->id_user,
                ];
                $rsv->sign_approval_3 = Carbon::now();
                $rsv->sign_approval_5 = Carbon::now();
                $rsv->status_bayar = 'PAYED';

                broadcast(new HelloEvent($dataNotif));
            }

            $rsv->sign_approval_2 = Carbon::now();
            $rsv->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal');

            return redirect()->back();
        }

        Alert::success('Berhasil', 'Berhasil approve reservasi');

        return redirect()->back();
    }

    public function approve3($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);

        $rsv->sign_approval_3 = Carbon::now();
        $rsv->save();
        $rsv->Ticket->status_request = 'APPROVED';
        $rsv->Ticket->save();

        Alert::success('Berhasil', 'Berhasil approve reservasi');

        return redirect()->back();
    }

    public function rsvDone(Request $request, $id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $rsv = $connReservation->find($id);

        $rsv->Ticket->status_request = 'DONE';
        $rsv->Ticket->save();

        $user = $request->session()->get('user');
        $approve = $connApprove->find(7);
        $dataNotif = [
            'models' => 'Reservation',
            'notif_title' => $rsv->no_request_reservation,
            'id_data' => $rsv->id,
            'sender' => $user->id_user,
            'division_receiver' => null,
            'notif_message' => 'Reservation telah selesai, mohon complete reservasi',
            'receiver' => $approve->approval_4
        ];

        broadcast(new HelloEvent($dataNotif));
        Alert::success('Berhasil', 'Berhasil update reservasi');

        return redirect()->back();
    }

    public function rsvComplete($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);

        $rsv->sign_approval_4 = Carbon::now();
        $rsv->save();
        $rsv->Ticket->status_request = 'COMPLETE';
        $rsv->Ticket->save();

        Alert::success('Berhasil', 'Berhasil update reservasi');

        return redirect()->back();
    }

    public function generatePaymentRSV(Request $request, $id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $user = $request->session()->get('user');
        $site = Site::find($user->id_site);

        $rsv = $connReservation->find($id);
        $transaction = $rsv->CashReceipt;

        $client = new Client();
        $billing = explode(',', $request->billing);
        $admin_fee = $request->admin_fee;

        if ($rsv->CashReceipt->transaction_status = 'PENDING') {
            if ($billing[0] == 'bank_transfer') {
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

                $transaction->va_number = $response->va_numbers[0]->va_number;
                $transaction->expiry_time = $response->expiry_time;
                $transaction->transaction_status = 'VERIFYING';
                $transaction->admin_fee = $admin_fee;
                $transaction->save();

                return redirect()->route('paymentReservation', [$rsv->id, $transaction->id]);
            } elseif ($request->billing == 'credit_card') {
                $transaction->payment_type = 'credit_card';
                $transaction->admin_fee = $admin_fee;
                $transaction->gross_amount = round($transaction->sub_total + $admin_fee);

                $getTokenCC = $this->TransactionCC($request);
                $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $transaction);

                $transaction->save();

                return redirect($chargeCC->redirect_url);
            }
        } else {
            return redirect()->back();
        }
    }

    public function TransactionCC($request)
    {
        $expDate = explode('/', $request->expDate);
        $card_exp_month = $expDate[0];
        $card_exp_year = $expDate[1];

        $login = Auth::user();
        $site = Site::find($login->id_site);

        try {
            $token = CoreApi::cardToken(
                $request->card_number,
                $card_exp_month,
                $card_exp_year,
                $request->card_cvv,
                $site->midtrans_client_key
            );

            if ($token->status_code != 200) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 401);
            }

            return $token;
        } catch (\Throwable $e) {
            dd($e);
            return ResponseFormatter::error([
                'message' => 'Internar Error'
            ], 'Something went wrong', 500);
        }

        return response()->json(['token' => $token]);
    }

    public function ChargeTransactionCC($token, $transaction)
    {
        $login = Auth::user();
        $site = Site::find($login->id_site);
        $server_key = $site->midtrans_server_key;

        try {
            $credit_card = array(
                'token_id' => $token,
                'authentication' => true,
                'bank' => 'bni'
            );

            $transactionData = array(
                "payment_type" => "credit_card",
                "transaction_details" => [
                    "gross_amount" => $transaction->gross_amount,
                    "order_id" => $transaction->order_id
                ],
            );

            $transactionData["credit_card"] = $credit_card;
            $result = CoreApi::charge($transactionData, $server_key);

            return $result;
        } catch (Throwable $e) {
            dd($e);
        }
    }

    public function paymentReservation($rsv, $id)
    {
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $connRSV = ConnectionDB::setConnection(new Reservation());

        $mt = $connRSV->find($rsv);
        $transaction = $connTransaction->find($id);

        $data['rsv'] = $rsv;
        $data['transaction'] = $transaction;

        return view('Tenant.Notification.Invoice.payment-reservation', $data);
    }
}
