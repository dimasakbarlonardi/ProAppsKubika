<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
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

    public function store(Request $request)
    {
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
            // $connDetailWO->whereNotIn('id', $idDetailServices)->delete();

            DB::commit();

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
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();

            $wo = $connWO->find($id);

            $checkNotif = $connNotif->where('models', 'WorkOrder')
                ->where('is_read', 0)
                ->where('id_data', $id)
                ->first();

            if (!$checkNotif) {
                $connNotif->create([
                    'receiver' => $wo->WorkRequest->Ticket->Tenant->User->id_user,
                    'sender' => $user->id_user,
                    'is_read' => 0,
                    'models' => 'WorkOrder',
                    'id_data' => $id,
                    'notif_title' => $wo->no_work_order,
                    'notif_message' => 'Persetujuan Work Order'
                ]);
            }

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

    public function acceptWO($id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_1 = '1';
        $wo->date_approve_1 = Carbon::now();
        $wo->save();

        Alert::success('Berhasil', 'Berhasil menerima WO');

        return redirect()->back();
    }

    public function approve2WO(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $user = $request->session()->get('user');
        $wo = $connWO->find($id);
        $getUser = $wo->WorkRequest->Ticket->Tenant->User;

        $wo->status_wo = 'WORK DONE';
        $wo->save();

        return response()->json(['status' => 'ok']);
    }

    public function approveTR(Request $request, $id)
    {
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $user = $request->session()->get('user');

        $getSpv = $connKaryawan->where('id_jabatan', '003')->get();

        $wo = $connWO->find($id);

        foreach ($getSpv as $spv) {
            $createNotif = $this->createNotif($connNotif, $id, $user, $wo);
            $createNotif->notif_message = 'Engineering sudah mengerjakan WO, mohon di periksa kembali';
            $createNotif->receiver = $spv->User->id_user;
            $createNotif->save();
        }

        $wo->sign_approve_tr = 1;
        $wo->date_approve_tr = Carbon::now();
        $wo->save();

        Alert::success('Berhasil', 'Berhasil approve WO');

        return redirect()->back();
    }

    public function approveSPV(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $user = $request->session()->get('user');

        $wo = $connWO->find($id);

        $getUser = $wo->Ticket->Tenant->User->id_user;

        $createNotif = $this->createNotif($connNotif, $id, $user, $wo);
        $createNotif->notif_message = 'Work Order sudah dikerjakan, mohon periksa kembali pekerjaan kami';
        $createNotif->receiver = $getUser;
        $createNotif->save();


        $wo->sign_approve_spv = 1;
        $wo->date_approve_spv = Carbon::now();
        $wo->save();

        Alert::success('Berhasil', 'Berhasil approve WO');

        return redirect()->back();
    }

    public function done($id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWR = ConnectionDB::setConnection(new WorkRequest());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $sender = $connApprove->find(3);
        $sender = $sender->approval_4;

        $wo = $connWO->find($id);
        $ticket = $connTicket->where('no_tiket', $wo->no_tiket)->first();
        $wr = $connWR->where('no_work_request', $wo->no_work_request)->first();
        $getUser = $wo->Ticket->Tenant->User->id_user;

        try {
            DB::beginTransaction();

            $wo->status_wo = 'DONE';
            $wo->save();

            $ticket->status_request = 'DONE';
            $ticket->save();

            $wr->status_request = 'DONE';
            $wr->save();

            $notif = $connNotif->where('models', 'WorkOrder')
                ->where('is_read', 0)
                ->where('id_data', $wo->id)
                ->first();

            if (!$notif) {
                $createNotif = $connNotif;
                $createNotif->sender = $sender;
                $createNotif->receiver = $getUser;
                $createNotif->is_read = 0;
                $createNotif->notif_title = $wo->no_work_order;
                $createNotif->notif_message = 'Harap melakukan pembayaran untuk menselesaikan transaksi';
                $createNotif->models = 'Transaction';
            }

            $createTransaction = $this->createTransaction($wo);
            $createNotif->id_data = $createTransaction->id;

            $createNotif->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back();
        }

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
        $getUser = $wo->Ticket->Tenant->User->id_user;

        try {
            DB::beginTransaction();

            $wo->status_wo = 'DONE';
            $wo->save();

            $ticket->status_request = 'DONE';
            $ticket->save();

            $wr->status_request = 'DONE';
            $wr->save();

            $notif = $connNotif->where('models', 'WorkOrder')
                ->where('is_read', 0)
                ->where('id_data', $wo->id)
                ->first();

            if (!$notif) {
                $createNotif = $connNotif;
                $createNotif->sender = $sender;
                $createNotif->receiver = $getUser;
                $createNotif->is_read = 0;
                $createNotif->notif_title = $wo->no_work_order;
                $createNotif->notif_message = 'Harap melakukan pembayaran untuk menselesaikan transaksi';
                $createNotif->models = 'Transaction';
            }

            $createTransaction = $this->createTransaction($wo);
            $createNotif->id_data = $createTransaction->id;

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
        $connTransaction = ConnectionDB::setConnection(new Transaction());
        $system = $connSystem->find(1);

        $count = $system->sequence_no_invoice + 1;
        $no_invoice = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $admin_fee = 5000;

        try {
            DB::beginTransaction();

            $total = $wo->jumlah_bayar_wo + $admin_fee;
            $items = $wo->WODetail;

            $createTransaction = $connTransaction;
            $createTransaction->no_invoice = $no_invoice;
            $createTransaction->transaction_type = 'WorkOrder';
            $createTransaction->no_transaction = $wo->no_work_order;
            $createTransaction->admin_fee = $admin_fee;
            $createTransaction->sub_total = $wo->jumlah_bayar_wo;
            $createTransaction->total = $total;
            $createTransaction->id_user = $wo->Ticket->Tenant->User->id_user;
            $createTransaction->status = 'PENDING';
            $createTransaction->save();

            $ct = $this->transactionCenter($createTransaction);

            $midtrans = new CreateSnapTokenService($ct, $createTransaction, $items, $admin_fee);

            $ct->snap_token = $midtrans->getSnapToken();
            $ct->save();

            $createTransaction->save();

            $system->sequence_no_invoice = $count;
            $system->save();


            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }

        return $createTransaction;
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

        Alert::success('Berhasil', 'Berhasil menselesaikan WO');

        return redirect()->back();
    }

    public function createTransaction($wo)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new Transaction());
        $system = $connSystem->find(1);

        $count = $system->sequence_no_invoice + 1;
        $no_invoice = $system->kode_unik_perusahaan . '-' .
            $system->kode_unik_invoice . '-' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '-' .
            sprintf("%06d", $count);

        $admin_fee = 5000;

        try {
            DB::beginTransaction();

            $total = $wo->jumlah_bayar_wo + $admin_fee;
            $items = $wo->WODetail;

            $createTransaction = $connTransaction;
            $createTransaction->no_invoice = $no_invoice;
            $createTransaction->transaction_type = 'WorkOrder';
            $createTransaction->no_transaction = $wo->no_work_order;
            $createTransaction->admin_fee = $admin_fee;
            $createTransaction->sub_total = $wo->jumlah_bayar_wo;
            $createTransaction->total = $total;
            $createTransaction->id_user = $wo->Ticket->Tenant->User->id_user;
            $createTransaction->status = 'PENDING';
            $createTransaction->save();
            $midtrans = new CreateSnapTokenService($createTransaction, $items, $admin_fee);
            $createTransaction->snap_token = $midtrans->getSnapToken();
            $createTransaction->save();

            $system->sequence_no_invoice = $count;
            $system->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }

        return $createTransaction;
    }

    public function complete($id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWR = ConnectionDB::setConnection(new WorkRequest());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $sender = $connApprove->find(3);
        $sender = $sender->approval_4;

        $wo = $connWO->find($id);
        $ticket = $connTicket->where('no_tiket', $wo->no_tiket)->first();
        $wr = $connWR->where('no_work_request', $wo->no_work_request)->first();

        try {
            DB::beginTransaction();

            $wo->status_wo = 'COMPLETE';
            $wo->sign_approval_5 = 1;
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
}
