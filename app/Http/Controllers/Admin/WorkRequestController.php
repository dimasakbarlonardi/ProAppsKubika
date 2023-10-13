<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\BayarNon;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\System;
use App\Models\User;
use App\Models\WorkRelation;
use App\Models\WorkRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class WorkRequestController extends Controller
{
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new WorkRequest());

        $user = $request->session()->get('user');
        if ($user->id_role_hdr != 8) {
            $role = $user->RoleH->WorkRelation->id_work_relation;
            $data['work_requests'] = $conn->where('id_work_relation', $role)->latest()->get();
        } else {
            $data['work_requests'] = $conn->latest()->get();
        }

        $data['user'] = $user;

        return view('AdminSite.WorkRequest.index', $data);
    }

    public function create()
    {
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());
        $connTicket = ConnectionDB::setConnection(new OpenTicket());

        $data['work_relations'] = $connWorkRelation->get();
        $data['tickets'] = $connTicket->where('status_request', 'PROSES KE WR')->get();

        return view('AdminSite.WorkRequest.create', $data);
    }

    public function store(Request $request)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connWorkRequest = ConnectionDB::setConnection(new WorkRequest());

        try {
            DB::beginTransaction();

            $ticket = $connTicket->where('id', $request->no_tiket)->first();
            $system = $connSystem->find(1);

            $count = $system->sequence_no_wr + 1;

            $no_work_request = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_wr . '/' .
                Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
                sprintf("%06d", $count);

            $connWorkRequest->no_tiket = $ticket->no_tiket;
            $connWorkRequest->deskripsi_wr = $request->deskripsi_wr;
            $connWorkRequest->status_request = 'PENDING';
            $connWorkRequest->no_work_request = $no_work_request;
            $connWorkRequest->id_work_relation = $request->id_work_relation;

            $connWorkRequest->save();

            $system->sequence_no_wr = $count;
            $system->save();

            $ticket->status_request = 'PROSES';
            $ticket->save();

            $dataNotif = [
                'models' => 'WorkRequest',
                'notif_title' => $no_work_request,
                'id_data' => $connWorkRequest->id,
                'sender' => $request->session()->get('user')->id_user,
                'division_receiver' => $request->id_work_relation,
                'notif_message' => 'Work Request baru, mohon segera dikerjakan',
                'receiver' => null,
            ];

            broadcast(new HelloEvent($dataNotif));

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan request');

            return redirect()->route('work-requests.index');
        } catch (Throwable $e) {
            dd($e);
            Alert::success('Error', $e);
            return redirect()->route('work-requests.create');
        }
    }

    public function show($id, Request $request)
    {
        $connWorkRequest = ConnectionDB::setConnection(new WorkRequest());
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());
        $user = $request->session()->get('user');

        $data['user'] = $user;
        $data['wr'] = $connWorkRequest->find($id);
        $data['work_relations'] = $connWorkRelation->get();

        return view('AdminSite.WorkRequest.show', $data);
    }

    public function update(Request $request, $id)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWorkRequest = ConnectionDB::setConnection(new WorkRequest());
        $wr = $connWorkRequest->find($id);
        $ticket = $connTicket->where('no_tiket', $wr->no_tiket)->first();

        if ($request->status_request == 'ON WORK') {
            $ticket->status_request = 'ON WORK';
            $wr->sign_approval_1 = 1;
            $wr->date_approval_1 = Carbon::now();
            $wr->save();
        } elseif ($request->status_request == 'WORK DONE') {
            $ticket->status_request = 'WORK DONE';

            $getUser = $ticket->Tenant->User;
            $user = $request->session()->get('user');

            $dataNotif = [
                'models' => 'WorkRequestT',
                'notif_title' => $wr->no_work_request,
                'id_data' => $id,
                'sender' => $user->id_user,
                'division_receiver' => null,
                'notif_message' => 'Work Request sudah dikerjakan, mohon periksa kembali pekerjaan kami',
                'receiver' => $getUser->id_user,
            ];

            broadcast(new HelloEvent($dataNotif));
        }

        $ticket->save();
        $wr->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate request');

        return redirect()->back();
    }

    public function done(Request $request, $id)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWR = ConnectionDB::setConnection(new WorkRequest());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $user = $request->session()->get('user');
        $approve = $connApprove->find(2);
        $wr = $connWR->find($id);
        $ticket = $connTicket->where('no_tiket', $wr->no_tiket)->first();

        $ticket->status_request = 'DONE';
        $ticket->save();
        $wr->status_request = 'DONE';
        $wr->save();

        $dataNotif = [
            'models' => 'WorkRequestT',
            'notif_title' => $ticket->no_tiket,
            'id_data' => $id,
            'sender' => $user->id_user,
            'division_receiver' => null,
            'notif_message' => 'Work Request sudah saya selesaikan',
            'receiver' => $approve->approval_2,
        ];

        broadcast(new HelloEvent($dataNotif));

        Alert::success('Berhasil', 'Berhasil approve WR');

        return redirect()->back();
    }

    public function complete($id)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWR = ConnectionDB::setConnection(new WorkRequest());

        $wr = $connWR->find($id);
        $ticket = $connTicket->where('no_tiket', $wr->no_tiket)->first();

        $ticket->status_request = 'COMPLETE';
        $ticket->save();
        $wr->status_request = 'COMPLETE';
        $wr->save();

        Alert::success('Success', 'Success completing WR');

        return redirect()->back();
    }
}
