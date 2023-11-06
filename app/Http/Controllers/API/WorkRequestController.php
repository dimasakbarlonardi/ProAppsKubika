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

class WorkRequestController extends Controller
{
    public function OnWork($id)
    {
        $connWR = ConnectionDB::setConnection(new AppWorkRequest);

        $wr = $connWR->find($id);

        $wr->Ticket->status_request = 'ON WORK';
        $wr->Ticket->save();

        $wr->status_request = 'ON WORK';
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
}
