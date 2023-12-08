<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use Carbon\Carbon;
use App\Models\Site;
use Midtrans\CoreApi;
use App\Models\System;
use GuzzleHttp\Client;
use App\Models\WorkOrder;
use App\Models\CashReceipt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\User;
use stdClass;

class WorkOrderController extends Controller
{
    public function show($id)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->where('id', $id)
            ->with(['Ticket.Tenant', 'WODetail', 'Ticket.Unit'])
            ->first();
        $wo->Ticket->deskripsi_request = strip_tags($wo->Ticket->deskripsi_request);
        $wo->Ticket->deskripsi_respon = strip_tags($wo->Ticket->deskripsi_respon);

        return ResponseFormatter::success(
            $wo,
            'Success get WO'
        );
    }

    public function acceptWO($id, Request $request)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->find($id);

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_1 = '1';
        $wo->date_approve_1 = Carbon::now();
        $wo->save();

        $dataNotif = [
            'models' => 'MApproveWorkOrder',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $wo->Ticket->Tenant->User->id_user,
            'division_receiver' => $wo->WorkRequest->id_work_relation,
            'notif_message' => 'Work order telah di terima, terima kasih..',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wo,
            'Success approve WO'
        );
    }

    public function rejectWO($id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        $dataNotif = [
            'models' => 'MApproveWorkOrder',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $wo->Ticket->Tenant->User->id_user,
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

        return ResponseFormatter::success(
            $wo,
            'Success reject WO'
        );
    }

    public function approve2($id, Request $request)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connUser = ConnectionDB::setConnection(new User());

        $wo = $connWO->find($id);
        $user = $connUser->where('login_user', $request->user()->email)->first();

        if ($wo->id_bayarnon == 0) {
            $dataNotif = [
                'models' => 'MApproveWorkOrder',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $user->id_user,
                'division_receiver' => 2,
                'notif_message' => 'Work order telah di terima, terima kasih..',
                'receiver' => null,
            ];
        } else {
            $dataNotif = [
                'models' => 'MApproveWorkOrder',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $user->id_user,
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

        return ResponseFormatter::success(
            $wo,
            'Success get WO'
        );
    }

    public function approveBM($id, Request $request)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connUser = ConnectionDB::setConnection(new User());

        $wo = $connWO->find($id);
        $user = $connUser->where('login_user', $request->user()->email)->first();

        if ($wo->id_bayarnon == 0) {
            $dataNotif = [
                'models' => 'MApproveWorkOrder',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $user->id_user,
                'division_receiver' => $wo->Ticket->WorkRequest->id_work_relation,
                'notif_message' => 'Work Order sudah diapprove, selamat bekerja',
                'receiver' => null,
            ];
        } else {
            $dataNotif = [
                'models' => 'MApproveWorkOrder',
                'notif_title' => $wo->no_work_order,
                'id_data' => $wo->id,
                'sender' => $user->id_user,
                'division_receiver' => null,
                'notif_message' => 'Work order telah di terima, terima kasih..',
                'receiver' => $connApprove->find(3)->approval_3,
            ];
        }

        $wo->status_wo = 'BM APPROVED';
        $wo->save();

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wo,
            'Success get WO'
        );
    }

    public function workDone($id, Request $request)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', $request->user()->email)->first();
        $wo = $connWO->find($id);

        $wo->status_wo = 'WORK DONE';
        $wo->save();

        $dataNotif = [
            'models' => 'TApproveWorkOrder',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $user->id_user,
            'division_receiver' => null,
            'notif_message' => 'Work Order sudah dikerjakan, mohon periksa kembali pekerjaan kami',
            'receiver' => $wo->WorkRequest->Ticket->Tenant->User->id_user,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wo,
            'Success update WO'
        );
    }

    public function done($id, Request $request)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        try {
            DB::beginTransaction();

            $wo->status_wo = 'DONE';
            $wo->save();

            $wo->Ticket->status_request = 'DONE';
            $wo->Ticket->save();

            $wo->WorkRequest->status_request = 'DONE';
            $wo->WorkRequest->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }

        $dataNotif = [
            'models' => 'MApproveWorkOrder',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $wo->Ticket->Tenant->User->id_user,
            'division_receiver' => 2,
            'notif_message' => 'Work order telah selesai, terima kasih..',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wo,
            'Success update WO'
        );
    }

    public function complete($id, Request $request)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        try {
            DB::beginTransaction();

            $wo->status_wo = 'COMPLETE';
            $wo->sign_approve_4 = 1;
            $wo->date_approve_4 = Carbon::now();
            $wo->save();

            $wo->Ticket->status_request = 'COMPLETE';
            $wo->Ticket->save();

            $wo->WorkRequest->status_request = 'COMPLETE';
            $wo->WorkRequest->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }

        return ResponseFormatter::success(
            $wo,
            'Success complete WO'
        );
    }
}
