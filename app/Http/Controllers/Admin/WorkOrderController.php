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
        $createNotif = $this->createNotif($connNotif, $id, $user, $wo);
        $createNotif->notif_message = 'Work Order sudah diapprove, menunggu persetujuan untuk pengerjaan';
        $createNotif->receiver = $approve->approval_3;
        $createNotif->save();

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_2 = 1;
        $wo->date_approve_2 = Carbon::now();
        $wo->save();

        return response()->json(['status' => 'ok']);
    }

    public function approve3WO(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_3 = 1;
        $wo->date_approve_3 = Carbon::now();
        $wo->save();

        Alert::success('Berhasil', 'Berhasil approve WO');

        return redirect()->back();
    }

        $notif = $connNotif->where('models', 'WorkOrder')
            ->where('is_read', 0)
            ->where('id_data', $id_data)
            ->first();

        if (!$notif) {
            $createNotif = $connNotif;
            $createNotif->sender = $user->id_user;
            $createNotif->is_read = 0;
            $createNotif->models = 'WorkOrder';
            $createNotif->id_data = $id_data;
            $createNotif->notif_title = $wo->no_work_order;
        }

        $wo->status_wo = 'WORK DONE';
        $wo->save();



        // if (!$checkNotif) {
        //     $connNotif->create([
        //         'receiver' => $getUser->id_user,
        //         'notif_title' => $wo->no_work_order,
        //         'notif_message' => 'Work Order sudah dikerjakan, mohon periksa kembali pekerjaan kami'
        //     ]);
        // }
        // dd('out');

        return response()->json(['status' => 'ok']);
    }

    public function workDone(Request $request, $id)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $sender = $connUser->where('id_role_hdr', 10)->first();

        $wo = $connWO->find($id);
        $getUser = $wo->WorkRequest->Ticket->Tenant->User;

        $notif = $connNotif->where('models', 'WorkOrder')
            ->where('is_read', 0)
            ->where('id_data', $id_data)
            ->first();

        if (!$notif) {
            $createNotif = $connNotif;
            $createNotif->sender = $user->id_user;
            $createNotif->is_read = 0;
            $createNotif->models = 'WorkOrder';
            $createNotif->id_data = $id_data;
            $createNotif->notif_title = $wo->no_work_order;
        }

        return $createNotif;
    }

    public function workDone(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $user = $request->session()->get('user');

        $wo = $connWO->find($id);
        $createNotif = $this->createNotif($connNotif, $id, $user, $wo);
        $createNotif->notif_message = 'Work Order sudah dikerjakan, mohon periksa kembali pekerjaan kami';
        $createNotif->division_receiver = 4;
        $createNotif->save();

        $wo->status_wo = 'WORK DONE';
        $wo->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back();
        }

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

        $wo->status_wo = 'DONE';
        $wo->save();
        $ticket->status_request = 'DONE';
        $ticket->save();
        $wr->status_request = 'DONE';
        $wr->save();

        Alert::success('Berhasil', 'Berhasil menselesaikan WO');

        return redirect()->back();
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
            $createTransaction->no_transaction = $wo->no_work_order;
            $createTransaction->admin_fee = $admin_fee;
            $createTransaction->sub_total = $wo->jumlah_bayar_wo;
            $createTransaction->total = $total;
            $createTransaction->id_user = $wo->Ticket->Tenant->User->id_user;

            $midtrans = new CreateSnapTokenService($createTransaction, $items, $admin_fee);
            $createTransaction->snap_token = $midtrans->getSnapToken();
            $createTransaction->save();

            $system->sequence_no_invoice = $count;
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
