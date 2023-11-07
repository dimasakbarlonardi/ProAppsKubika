<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\CashReceipt;
use App\Models\Karyawan;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\System;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use App\Models\WorkRequest;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class WorkOrderController extends Controller
{
    public function index()
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $data['wos'] = $connWO->latest()->get();

        return view('AdminSite.WorkOrder.index', $data);
    }

    public function filteredData(Request $request)
    { }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi_wr' => 'required',
            'services' => 'required',
            'id_bayarnon' => 'required',
        ]);

        $connSystem = ConnectionDB::setConnection(new System());
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connDetailWO = ConnectionDB::setConnection(new WorkOrderDetail());
        $connSystem = ConnectionDB::setConnection(new System());
        $connWR = ConnectionDB::setConnection(new WorkRequest());

        $system = $connSystem->find(1);
        $count = $system->sequence_no_wo + 1;
        $idDetailServices = [];
        $jumlah_bayar_wo = 0;

        $no_work_order = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_wo . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        try {
            DB::beginTransaction();

            $wo = $connWO->where('no_work_request', $request->no_work_request)->first();
            $connWR->where('no_work_request', $request->no_work_request)->first()->update([
                'deskripsi_wr' => $request->deskripsi_wr,
                'status_request' => 'WORK ORDER'
            ]);

            if ($wo == null) {
                $wo = $connWO->create([
                    'no_tiket' => $request->no_tiket,
                    'no_work_order' => $no_work_order,
                    'no_work_request' => $request->no_work_request,
                    'id_bayarnon' => (int) $request->id_bayarnon,
                    'status_wo' => 'PENDING',
                    'estimasi_pengerjaan' => $request->estimasi_pengerjaan
                ]);

                if ($request->id_bayarnon == "1") {
                    foreach ($request->services as $service) {
                        $connDetailWO->create([
                            'id' => $service['id'],
                            'no_work_order' => $wo->no_work_order,
                            'detil_pekerjaan' => $service['detil_pekerjaan'],
                            'detil_biaya_alat' => $service['detil_biaya_alat']
                        ]);
                        $jumlah_bayar_wo += $service['detil_biaya_alat'];
                    }
                }
            } else {
                $wo->update($request->all());
                if ($request->services) {
                    foreach ($request->services as $service) {
                        $checkDetailWO = $connDetailWO->find($service['id']);

                        if (!isset($checkDetailWO)) {
                            $createDetil = $connDetailWO->create([
                                'id' => $service['id'],
                                'no_work_order' => $wo->no_work_order,
                                'detil_pekerjaan' => $service['detil_pekerjaan'],
                                'detil_biaya_alat' => $service['detil_biaya_alat']
                            ]);
                            $idDetailServices[] = $createDetil->id;
                            $jumlah_bayar_wo += $service['detil_biaya_alat'];
                        } else {
                            $jumlah_bayar_wo += $service['detil_biaya_alat'];
                        }
                        $idDetailServices[] = $service['id'];
                    }
                }
            }

            $wo->jumlah_bayar_wo = $jumlah_bayar_wo;
            $wo->save();

            $system->sequence_no_wo = $count;
            $system->save();

            DB::commit();

            $dataNotif = [
                'models' => 'WorkOrderM',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $request->session()->get('user')->id_user,
                'division_receiver' => 1,
                'notif_message' => 'Pekerjaan memerlukan Work Order, mohon segera diperiksa',
                'receiver' => null,
            ];

            broadcast(new HelloEvent($dataNotif));

            return response()->json($wo->no_work_order);
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Error', $e);
            return redirect()->route('work-orders.index');
        }
    }

    public function showByNoWO(Request $request)
    {
        $connDetailWO = ConnectionDB::setConnection(new WorkOrderDetail());
        $services = [];

        if ($request->noWO) {
            $getServices = $connDetailWO->where('no_work_order', $request->noWO)->get();
            foreach ($getServices as $item) {
                $services[] = $item;
            }
        }

        return response()->json($services);
    }

    public function show($id, Request $request)
    {
        $user = $request->session()->get('user');
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $data['wo'] = $connWO->find($id);
        $data['user'] = $user;
        $data['approve'] = $connApprove->find(3);

        return view('AdminSite.WorkOrder.show', $data);
    }

    public function update(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        try {
            DB::beginTransaction();

            $wo = $connWO->find($id);

            $dataNotif = [
                'models' => 'WorkOrder',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $request->session()->get('user')->id_user,
                'division_receiver' => null,
                'notif_message' => 'Persetujuan Work Order',
                'receiver' => $wo->Ticket->Tenant->User->id_user,
            ];

            broadcast(new HelloEvent($dataNotif));

            $wo->jadwal_pengerjaan = $request->jadwal_pengerjaan;
            $wo->status_wo = 'WAITING APPROVE';
            $wo->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
        }

        Alert::success('Berhasil', 'Work Order dikirimkan ke tenant');

        return redirect()->back();
    }

    public function acceptWO(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        if ($wo->id_bayarnon == 0) {
            $wo->sign_approve_5 = '1';
            $wo->date_approve_5 = Carbon::now();
            $wo->sign_approve_3 = '1';
            $wo->date_approve_3 = Carbon::now();
        }

        $dataNotif = [
            'models' => 'WorkOrderM',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $request->session()->get('user')->id_user,
            'division_receiver' => $wo->WorkRequest->id_work_relation,
            'notif_message' => 'Work order telah di terima, terima kasih..',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_1 = '1';
        $wo->date_approve_1 = Carbon::now();
        $wo->save();

        broadcast(new HelloEvent($dataNotif));

        Alert::success('Berhasil', 'Berhasil menerima WO');

        return redirect()->back();
    }

    public function rejectWO(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        $dataNotif = [
            'models' => 'WorkOrderM',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $request->session()->get('user')->id_user,
            'division_receiver' => 1,
            'notif_message' => 'Maaf work request kali ini saya tolak..',
            'receiver' => null,
        ];

        $wo->status_wo = 'REJECTED';
        $wo->save();

        $wo->WorkRequest->status_request = 'REJECTED';
        $wo->WorkRequest->save();

        $wo->Ticket->status_request = 'REJECTED';
        $wo->Ticket->save();

        broadcast(new HelloEvent($dataNotif));

        Alert::success('Success', 'Success reject Work Order');

        return redirect()->back();
    }

    public function approve2(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $wo = $connWO->find($id);

        if ($wo->id_bayarnon == 0) {
            $dataNotif = [
                'models' => 'WorkOrderM',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $request->session()->get('user')->id_user,
                'division_receiver' => 2,
                'notif_message' => 'Work order telah di terima, terima kasih..',
                'receiver' => null,
            ];
        } else {
            $dataNotif = [
                'models' => 'WorkOrderM',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $request->session()->get('user')->id_user,
                'division_receiver' => null,
                'notif_message' => 'Work order telah di terima, terima kasih..',
                'receiver' => $connApprove->find(3)->approval_4,
            ];
        }

        broadcast(new HelloEvent($dataNotif));

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_2 = 1;
        $wo->date_approve_2 = Carbon::now();
        $wo->save();

        return response()->json(['status' => 'ok']);
    }

    public function approveBM(Request $request, $id)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        if ($wo->id_bayarnon == 0) {
            $dataNotif = [
                'models' => 'WorkOrderM',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $request->session()->get('user')->id_user,
                'division_receiver' => $wo->Ticket->WorkRequest->id_work_relation,
                'notif_message' => 'Work Order sudah diapprove, selamat bekerja',
                'receiver' => null,
            ];
        } else {
            $dataNotif = [
                'models' => 'WorkOrderM',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $request->session()->get('user')->id_user,
                'division_receiver' => null,
                'notif_message' => 'Work order telah di terima, terima kasih..',
                'receiver' => $connApprove->find(3)->approval_3,
            ];
        }

        $wo->status_wo = 'BM APPROVED';
        $wo->save();

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function approve3(Request $request, $id)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        if ($wo->id_bayarnon == 0) {
            $dataNotif = [
                'models' => 'WorkOrderM',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $request->session()->get('user')->id_user,
                'division_receiver' => $wo->Ticket->WorkRequest->id_work_relation,
                'notif_message' => 'Work Order sudah diapprove, selamat bekerja',
                'receiver' => null,
            ];
            broadcast(new HelloEvent($dataNotif));
        } else {
            $createTransaction = $this->createTransaction($wo);
            $wo->Ticket->np_invoice = $createTransaction->no_invoice;
            $dataNotif = [
                'models' => 'PaymentWO',
                'notif_title' => $wo->no_work_order,
                'id_data' => $createTransaction->id,
                'sender' => $connApprove->find(3)->approval_3,
                'division_receiver' => null,
                'notif_message' => 'Harap melakukan pembayaran untuk menselesaikan transaksi',
                'receiver' => $wo->WorkRequest->Ticket->Tenant->User->id_user,
            ];
            broadcast(new HelloEvent($dataNotif));
        }

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_3 = 1;
        $wo->date_approve_3 = Carbon::now();
        $wo->save();


        return response()->json(['status' => 'ok']);
    }

    public function workDone(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        $wo->status_wo = 'WORK DONE';
        $wo->save();

        $dataNotif = [
            'models' => 'WorkOrder',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $request->session()->get('user')->id_user,
            'division_receiver' => null,
            'notif_message' => 'Work Order sudah dikerjakan, mohon periksa kembali pekerjaan kami',
            'receiver' => $wo->WorkRequest->Ticket->Tenant->User->id_user,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function done($id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWR = ConnectionDB::setConnection(new WorkRequest());

        $wo = $connWO->find($id);
        $ticket = $connTicket->where('no_tiket', $wo->no_tiket)->first();
        $wr = $connWR->where('no_work_request', $wo->no_work_request)->first();

        try {
            DB::beginTransaction();

            $wo->status_wo = 'DONE';
            $wo->save();

            $ticket->status_request = 'DONE';
            $ticket->save();

            $wr->status_request = 'DONE';
            $wr->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }

        $dataNotif = [
            'models' => 'WorkOrderM',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $ticket->Tenant->User->id_user,
            'division_receiver' => 2,
            'notif_message' => 'Work order telah selesai, terima kasih..',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        Alert::success('Berhasil', 'Berhasil menselesaikan WO');

        return redirect()->back();
    }

    public function completeWO(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWR = ConnectionDB::setConnection(new WorkRequest());

        $wo = $connWO->find($id);
        $ticket = $connTicket->where('no_tiket', $wo->no_tiket)->first();
        $wr = $connWR->where('no_work_request', $wo->no_work_request)->first();

        try {
            DB::beginTransaction();

            $wo->status_wo = 'COMPLETE';
            $wo->sign_approve_4 = 1;
            $wo->date_approve_4 = Carbon::now();
            $wo->save();

            $ticket->status_request = 'COMPLETE';
            $ticket->save();

            $wr->status_request = 'COMPLETE';
            $wr->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }

        return response()->json(['status' => 'ok']);
    }

    public function createTransaction($wo)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $system = $connSystem->find(1);
        $request = Request();
        $user = $request->session()->get('user');
        $count = $system->sequence_no_cash_receiptment + 1;
        $no_cr = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_cash_receipt . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $order_id = $user->id_site . '-' . $no_cr;
        $countINV = $system->sequence_no_invoice + 1;

        $no_inv = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countINV);

        try {
            DB::beginTransaction();

            $createTransaction = $connTransaction;
            $createTransaction->order_id = $order_id;
            $createTransaction->id_site = $user->id_site;
            $createTransaction->no_reff = $wo->no_work_order;
            $createTransaction->no_draft_cr = $no_cr;
            $createTransaction->ket_pembayaran = 'WO/' . $wo->Ticket->Tenant->User->id_user . '/' . $wo->Ticket->Unit->nama_unit;
            $createTransaction->sub_total = $wo->jumlah_bayar_wo;
            $createTransaction->no_invoice = $no_inv;
            $createTransaction->transaction_status = 'PENDING';
            $createTransaction->id_user = $wo->Ticket->Tenant->User->id_user;
            $createTransaction->transaction_type = 'WorkOrder';
            $createTransaction->save();

            $wo->Ticket->no_invoice = $no_inv;
            $wo->Ticket->save();

            $system->sequence_no_invoice = $countINV;
            $system->sequence_no_cash_receiptment = $count;
            $system->save();


            DB::commit();
        } catch (Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back();
        }

        return $createTransaction;
    }
}
