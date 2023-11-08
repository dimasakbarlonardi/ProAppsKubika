<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Helpers\SaveFile;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\DetailGIGO;
use App\Models\JenisRequest;
use App\Models\OpenTicket;
use App\Models\RequestGIGO;
use App\Models\RequestPermit;
use App\Models\Reservation;
use App\Models\Site;
use App\Models\System;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkPermit;
use App\Models\WorkRequest;
use Carbon\Carbon;
use File;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use stdClass;
use Validator;
use Throwable;

class OpenTicketController extends Controller
{
    public function user()
    {
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', Auth::user()->email)->first();

        return $user;
    }
    public function listTickets()
    {
        $user = $this->user();

        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());

        $tickets = $connOpenTicket->where('id_tenant', $user->Tenant->id_tenant)
            ->get();

        foreach ($tickets as $ticket) {
            $ticket['request_type'] = 'Complaint';

            if ($ticket->WorkRequest) {
                $ticket['request_type'] = 'WorkRequest';
            }
            if ($ticket->RequestReservation) {
                $ticket['request_type'] = 'Reservation';
            }
            if ($ticket->WorkOrder) {
                $ticket['request_type'] = 'WorkOrder';
            }
            if ($ticket->WorkPermit) {
                $ticket['request_type'] = 'WorkPermit';
            }
            if ($ticket->RequestPermit) {
                $ticket['request_type'] = 'Permit';
            }
            if ($ticket->RequestGIGO) {
                $ticket['request_type'] = 'GIGO';
            }
        }

        return ResponseFormatter::success(
            $tickets,
            'Berhasil mengambil semua tickets'
        );
    }
    public function jenisRequest(Request $request)
    {
        $connJenisReq = ConnectionDB::setConnection(new JenisRequest());

        $jenis_requests = $connJenisReq->get();

        return ResponseFormatter::success([
            $jenis_requests
        ], 'Berhasil mengambil jenis request');
    }

    public function store(Request $request)
    {
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', $request->user()->email)->first();
        $tenant = $user->Tenant->id_tenant;

        $rules = [
            'id_jenis_request' => 'required',
        ];
        $message = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return ResponseFormatter::error(
                null,
                'Gagal membuat ticket, harap mengisi semua form'
            );
        }
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());

        $system = $connSystem->find(1);
        $count = $system->sequence_notiket + 1;

        $nowDate = Carbon::now();
        try {
            DB::beginTransaction();
            $unit = $connUnit->find($request->id_unit);

            $no_tiket = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_tiket . '/' .
                Carbon::now()->format('m') . $nowDate->year . '/' .
                sprintf("%06d", $count);

            $createTicket = $connOpenTicket->create($request->all());
            $createTicket->id_jenis_request = $request->id_jenis_request;
            $createTicket->judul_request = $request->judul_request;
            $createTicket->id_site = $unit->id_site;
            $createTicket->id_tenant = $tenant;
            $createTicket->id_tower = $unit->id_tower;
            $createTicket->id_unit = $request->id_unit;
            $createTicket->id_lantai = $unit->id_lantai;
            $createTicket->no_tiket = $no_tiket;
            $createTicket->status_request = 'PENDING';
            $createTicket->deskripsi_request = $request->deskripsi_request;
            $createTicket->no_hp = $request->no_hp;

            $file = $request->file('upload_image');

            if ($file) {
                $storagePath = SaveFile::saveToStorage($request->user()->id_site, 'request', $file);
                $createTicket->upload_image = $storagePath;
            }

            $createTicket->save();
            $system->sequence_notiket = $count;
            $system->save();
            $dataNotif = [
                'models' => 'OpenTicket',
                'notif_title' => $createTicket->no_tiket,
                'id_data' => $createTicket->id,
                'sender' => $this->user()->id_user,
                'division_receiver' => 1,
                'notif_message' => 'Tiket sudah dibuat, mohon proses request saya',
                'receiver' => null,
            ];

            $system->save();
            $createTicket->save();

            broadcast(new HelloEvent($dataNotif));

            DB::commit();

            return ResponseFormatter::success([
                $createTicket
            ], 'Berhasil membuat ticket');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal membuat ticket');
        }
    }

    public function show($id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());
        $connDetailGIGO = ConnectionDB::setConnection(new DetailGIGO());
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connWR = ConnectionDB::setConnection(new WorkRequest());
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $ticket = $connRequest->find($id);

        $item = new stdClass();
        $item->ticket['no_tiket'] = $ticket->no_tiket;
        $item->ticket['request_title'] = $ticket->judul_request;
        $item->ticket['request_date'] = $ticket->created_at;
        $item->ticket['unit'] = $ticket->Unit->nama_unit;
        $item->ticket['tenant'] = $ticket->Tenant->nama_tenant;
        $item->ticket['upload_image'] = null;

        if ($ticket->id_jenis_request == 1) {
            $wo = $connWO->where('no_tiket', $ticket->no_tiket)->first();
            $item->ticket['deskripsi_request'] = strip_tags($ticket->deskripsi_request);
            $item->ticket['upload_image'] = $ticket->upload_image;

            if ($wo) {
                $item->ticket['request_type'] = 'WorkOrder';
                $item->request = $wo;
            } else {
                $wr = $connWR->where('no_tiket', $ticket->no_tiket)->first();
                $item->ticket['request_type'] = 'WorkRequest';
                $item->request = $wr;
            }
        }

        if ($ticket->id_jenis_request == 2) {
            $rp = $connRP->where('no_tiket', $ticket->no_tiket)->first();
            $wp = $connWP->where('no_tiket', $ticket->no_tiket)->first();


            // dd($data);
            if ($wp) {
                $item->ticket['request_type'] = 'WorkPermit';
                $item->request = $wp;
            } else {
                $item->ticket['request_type'] = 'RequestPermit';
                $item->request = $rp;
            }
            $item->ticket['deskripsi_request'] = strip_tags($rp->keterangan_pekerjaan);

            $dataJSON = json_decode($wp->RequestPermit->RPDetail->data);
            $dataJSON = json_decode($dataJSON);

            $data['personels'] = $dataJSON->personels;
            $data['alats'] = $dataJSON->alats;
            $data['materials'] = $dataJSON->materials;

            $item->request['personels'] =  $data['personels'];
            $item->request['alats'] =  $data['alats'];
            $item->request['materials'] =  $data['materials'];
        }

        if ($ticket->id_jenis_request == 4) {
            $rsv = $connReservation->where('no_tiket', $ticket->no_tiket)->first();

            $item->ticket['request_type'] = 'Reservation';

            $item->request = $rsv;
            $item->ticket['deskripsi_request'] = strip_tags($rsv->keterangan);
        }

        if ($ticket->id_jenis_request == 5) {
            $gigo = $connGIGO->where('no_tiket', $ticket->no_tiket)->first();
            $detail_gigo = $connDetailGIGO->where('id_request_gigo', $gigo->id)->get();

            $request = $gigo;
            $item->ticket['request_type'] = 'GIGO';
            $request['detail'] = $detail_gigo;

            $item->request = $request;
            $item->ticket['deskripsi_request'] = null;
        }

        $item->ticket['deskripsi_respon'] = strip_tags($ticket->deskripsi_respon);

        return ResponseFormatter::success(
            $item,
            'Berhasil mengambil request'
        );
    }

    public function payableTickets($id)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());

        $tickets = $connTicket->where('no_invoice', '!=', null)
            ->where('id_unit', $id)
            ->with('CashReceipt')
            ->get();

        return ResponseFormatter::success(
            $tickets,
            'Success get transactions'
        );
    }

    public function payableTicketShow($id)
    {
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());

        $cr = $connTransaction->find($id);

        $login = Auth::user();
        $site = Site::find($login->id_site);

        switch ($cr->transaction_type) {
            case ('Reservation'):
                $object = $this->ReservationInvoice($cr);
                break;
            case ('WorkOrder'):
                $object = $this->WorkOrderInvoice($cr);
                break;
            case ('WorkPermit'):
                $object = $this->WorkPermitInvoice($cr);
                break;
        }

        $object->transaction_id = $cr->id;
        $object->no_invoice = $cr->no_invoice;
        $object->issued_date = $cr->created_at;
        $object->site = $site->province;
        $object->site = $site->kode_pos;
        $object->bank = $cr->bank;
        $object->transaction_status = $cr->transaction_status;
        $object->payment_type = $cr->payment_type;
        $object->va_number = $cr->va_number;
        $object->expiry_time = $cr->expiry_time;
        $object->admin_fee = $cr->admin_fee;
        $object->gross_amount = $cr->gross_amount;
        $object->tax = $cr->tax;

        return ResponseFormatter::success(
            $object,
            'Success get transaction'
        );
    }

    function WorkPermitInvoice($cr)
    {
        $object = new stdClass();

        $object->id = $cr->id;
        $object->work_order_id = $cr->WorkPermit->id;
        $object->tenant_name = $cr->WorkPermit->Ticket->Tenant->nama_tenant;
        $object->tower = $cr->WorkPermit->Ticket->Unit->Tower->nama_tower;
        $object->tower = $cr->WorkPermit->Ticket->Unit->nama_unit;
        $object->tenant_email = $cr->WorkPermit->Ticket->Tenant->email_tenant;
        $object->phone_number_tenant = $cr->WorkPermit->Ticket->Tenant->no_telp_tenant;
        $object->total = $cr->sub_total;

        return $object;
    }

    function WorkOrderInvoice($cr)
    {
        $object = new stdClass();

        $object->id = $cr->id;
        $object->work_order_id = $cr->WorkOrder->id;
        $object->tenant_name = $cr->WorkOrder->Ticket->Tenant->nama_tenant;
        $object->tower = $cr->WorkOrder->Ticket->Unit->Tower->nama_tower;
        $object->tower = $cr->WorkOrder->Ticket->Unit->nama_unit;
        $object->tenant_email = $cr->WorkOrder->Ticket->Tenant->email_tenant;
        $object->phone_number_tenant = $cr->WorkOrder->Ticket->Tenant->no_telp_tenant;

        $request_details = [];
        foreach ($cr->WorkOrder->WODetail as $itemWO) {
            $item = new stdClass();
            $item->billing = $itemWO->detil_pekerjaan;
            $item->price = $itemWO->detil_biaya_alat;

            $request_details[] = $item;
        }

        $object->items = $request_details;
        $object->total = $cr->sub_total;

        return $object;
    }

    function ReservationInvoice($cr)
    {
        $object = new stdClass();

        $object->id = $cr->id;
        $object->reservation_id = $cr->Reservation->id;
        $object->tenant_name = $cr->Reservation->Ticket->Tenant->nama_tenant;
        $object->tower = $cr->Reservation->Ticket->Unit->Tower->nama_tower;
        $object->tower = $cr->Reservation->Ticket->Unit->nama_unit;
        $object->tenant_email = $cr->Reservation->Ticket->Tenant->email_tenant;
        $object->phone_number_tenant = $cr->Reservation->Ticket->Tenant->no_telp_tenant;

        $request_details = [];

        $item = new stdClass();
        $item->billing = 'Pembayaran reservasi';
        $item->price = $cr->sub_total;

        $request_details[] = $item;

        $object->items = $request_details;
        $object->total = $cr->sub_total;

        return $object;
    }

    public function GeneratePayment(Request $request, $id)
    {
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());

        $client = new Client();
        $cr = $connTransaction->find($id);
        $site = Site::find($request->user()->id_site);

        $client = new Client();
        $admin_fee = (int) $request->admin_fee;
        $type = $request->type;
        $bank = $request->bank;

        if ($cr->transaction_status == 'PENDING') {
            if ($type == 'bank_transfer') {
                $cr->gross_amount = $cr->sub_total + $admin_fee;
                $cr->payment_type = 'bank_transfer';
                $cr->bank = Str::upper($bank);

                $tax = $request->tax;
                $gross_amount = $cr->sub_total + $tax + $admin_fee;

                $payment = [];
                $payment['payment_type'] = $type;
                $payment['transaction_details']['order_id'] = $cr->order_id;
                $payment['transaction_details']['gross_amount'] = round($gross_amount);
                $payment['bank_transfer']['bank'] = $bank;

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

                $cr->va_number = $response->va_numbers[0]->va_number;
                $cr->transaction_id = $response->transaction_id;
                $cr->expiry_time = $response->expiry_time;
                $cr->admin_fee = $admin_fee;
                $cr->transaction_status = 'VERIFYING';

                $cr->tax = $tax;
                $cr->gross_amount = $gross_amount;
                $cr->save();

                return ResponseFormatter::success(
                    $response,
                    'Authenticated'
                );
            } elseif ($type == 'credit_card') {
                $cr->payment_type = 'credit_card';
                $cr->admin_fee = $admin_fee;
                $cr->gross_amount = round($cr->sub_total + $admin_fee);
                $cr->transaction_status = 'VERIFYING';

                $getTokenCC = $this->TransactionCC($request, $site);
                $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $cr, $site);

                $cr->save();

                return ResponseFormatter::success(
                    $chargeCC
                );
            }
        } else {
            return ResponseFormatter::success(
                'Transaction has created'
            );
        }
    }

    public function TransactionCC($request, $site)
    {
        $expDate = explode('/', $request->expDate);
        $card_exp_month = $expDate[0];
        $card_exp_year = $expDate[1];

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

    public function ChargeTransactionCC($token, $transaction, $site)
    {
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
}
