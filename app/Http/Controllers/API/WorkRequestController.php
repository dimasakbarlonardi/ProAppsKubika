<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkRequest as AppWorkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use stdClass;

class WorkRequestController extends Controller
{
    public function show($id)
    {
        $connWR = ConnectionDB::setConnection(new AppWorkRequest);

        $wr = $connWR->find($id);

        $object = new stdClass();
        $object->request_number = $wr->no_tiket;
        $object->request_title = $wr->Ticket->judul_request;
        $object->request_type = 'Complaint';
        $object->request_date = $wr->Ticket->created_at;
        $object->unit = $wr->Ticket->Unit->nama_unit;
        $object->tenant = $wr->Ticket->Tenant->nama_tenant;
        $object->description = strip_tags($wr->Ticket->deskripsi_request);
        $object->work_request_number = $wr->no_work_request;
        $object->work_relation = $wr->WorkRelation->work_relation;
        $object->schedule = $wr->schedule;
        $object->is_working = $wr->is_working;
        $object->is_worked = $wr->is_worked;

        return ResponseFormatter::success(
            $object,
            'Success get WR'
        );
    }
    public function OnWork($id)
    {
        $connWR = ConnectionDB::setConnection(new AppWorkRequest);

        $wr = $connWR->find($id);

        $wr->Ticket->status_request = 'ON WORK';
        $wr->Ticket->save();

        $wr->status_request = 'ON WORK';
        $wr->is_working = true;
        $wr->sign_approval_1 = 1;
        $wr->date_approval_1 = Carbon::now();
        $wr->save();

        return ResponseFormatter::success(
            $wr,
            'Success update WR'
        );
    }

    public function WorkDone($id, Request $request)
    {
        $connWR = ConnectionDB::setConnection(new AppWorkRequest);
        $connUser = ConnectionDB::setConnection(new User());

        $wr = $connWR->find($id);
        $user = $connUser->where('login_user', $request->user()->email)->first();

        $wr->Ticket->status_request = 'WORK DONE';
        $wr->Ticket->save();

        $wr->status_request = 'WORK DONE';
        $wr->is_worked = true;
        $wr->deskripsi_wr = $request->work_description;
        $wr->save();

        $dataNotif = [
            'models' => 'WorkRequestT',
            'notif_title' => $wr->no_work_request,
            'id_data' => $id,
            'sender' => $user->id_user,
            'division_receiver' => null,
            'notif_message' => 'Work Request sudah dikerjakan, mohon periksa kembali pekerjaan kami',
            'receiver' => $wr->Ticket->Tenant->User->id_user,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wr,
            'Success update WR'
        );
    }

    public function Done($id, Request $request)
    {
        $connWR = ConnectionDB::setConnection(new AppWorkRequest);
        $connUser = ConnectionDB::setConnection(new User());

        $wr = $connWR->find($id);
        $user = $connUser->where('login_user', $request->user()->email)->first();

        $wr->Ticket->status_request = 'DONE';
        $wr->Ticket->save();

        $wr->status_request = 'DONE';
        $wr->is_done = true;
        $wr->save();

        $dataNotif = [
            'models' => 'WorkRequest',
            'notif_title' => $wr->no_work_request,
            'id_data' => $id,
            'sender' => $user->id_user,
            'division_receiver' => 2,
            'notif_message' => 'Work Request sudah selesai, terimakasih',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wr,
            'Success update WR'
        );
    }

    public function Complete($id)
    {
        $connWR = ConnectionDB::setConnection(new AppWorkRequest);

        $wr = $connWR->find($id);

        $wr->Ticket->status_request = 'COMPLETE';
        $wr->Ticket->save();

        $wr->status_request = 'COMPLETE';
        $wr->save();

        return ResponseFormatter::success(
            $wr,
            'Success update WR'
        );
    }
}
