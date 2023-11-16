<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\OpenTicket;
use App\Models\Tenant;
use Illuminate\Http\Request;
use stdClass;

class MainFormController extends Controller
{
    public function index(Request $request)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connTenant = ConnectionDB::setConnection(new Tenant());


        $user = $request->session()->get('user');

        if ($user->user_category == 3) {
            $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
            $tickets = $connRequest->where('id_tenant', $tenant->id_tenant)->latest();
        } else {
            $tickets = $connRequest->where('deleted_at', null);
        }

        $data['tickets'] = $tickets->latest()->get();

        if ($request->input) {
            $data = $connRequest->where("no_tiket", "like", "%" . $request->input  . "%")->get();
            return response()->json([
                'html' => view('layouts.side-navigation')->render(),
            ]);
            return response()->json(['data' => $data]);
        } else {
            return view('AdminSite.TrackingTicket.index', $data);
        }
    }

    public function show(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        $ticket = $connRequest->where('id', $id)->with('Tenant')->first();
        $user = $request->session()->get('user');

        $data['ticket'] = $ticket;
        $data['user'] = $user;

        return view('AdminSite.TrackingTicket.show', $data);
    }

    public function trackTicket($id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        $ticket = $connRequest->find($id);

        $objects = [];

        $object = new stdClass();
        $object->is_done = true;
        $object->title = 'Ticket has created';
        $object->status_time = $ticket->created_at;
        $object->icon = null;
        $object->user = $ticket->Tenant->nama_tenant;
        $objects[] = $object;

        $object1 = new stdClass();
        $object1->is_done = $ticket->status_respon ? true : false;
        $object1->title = 'Request accepted by TR ';
        $object1->status_time = $ticket->status_respon == 'Responded' ? $ticket->tgl_respon_tiket . ' ' . $ticket->jam_respon : null;
        $object1->icon = null;
        $object1->user = $ticket->status_respon ? $ticket->ResponseBy->nama_user : null;
        $objects[] = $object1;

        switch ($ticket->id_jenis_request) {
            case 5:
                $objects = $this->trackGIGO($ticket, $objects);
                break;
            case 4:
                $objects = $this->trackRSV($ticket, $objects);
                break;
            case 2:
                $objects = $this->trackPermit($ticket, $objects);
                break;
            case 1:
                $objects = $this->trackComplaint($ticket, $objects);
                break;
        }

        $data['data'] = $objects;

        return response()->json([
            'html' => view('AdminSite.TrackingTicket.track-index', $data)->render(),
            'objects' => $objects
        ]);
    }

    function createObject($request, $title, $condition, $user, $time)
    {
        $object = new stdClass();
        $object->is_done = $request ? ($condition ? true : false) : false;
        $object->title = $title;
        $object->status_time = $time;
        $object->icon = null;
        $object->user = $request ? ($condition ? $user : null) : null;;

        return $object;
    }

    function trackGIGO($ticket, $objects)
    {
        $gigo = $ticket->RequestGIGO;
        $user = $ticket->Tenant->user->nama_user;

        $condition1 = $gigo->sign_approval_2;
        $track1 = $this->createObject($gigo, 'Request GIGO accepted by Security', $condition1, 'Security', $gigo->sign_approval_2);
        $objects[] = $track1;

        $condition2 = $gigo->status_request == 'DONE' || $gigo->status_request == 'COMPLETE';
        $track2 = $this->createObject($gigo, 'Request GIGO has done', $condition2, $user, $gigo->updated_at);
        $objects[] = $track2;

        $condition3 = $gigo->status_request == 'COMPLETE';
        $track3 = $this->createObject($gigo, 'Request GIGO has complete', $condition3, 'Building Manager', $gigo->sign_approval_3);
        $objects[] = $track3;

        return $objects;
    }

    function trackRSV($ticket, $objects)
    {
        $rsv = $ticket->RequestReservation;
        $user = $ticket->Tenant->nama_tenant;

        if ($ticket->RequestReservation->is_deposit) {
            $condition1 = $rsv->sign_approval_1;
            $track1 = $this->createObject($rsv, 'Tenant accept payment', $condition1, $user, $rsv->sign_approval_1);
            $objects[] = $track1;
        }

        $condition2 = $rsv->sign_approval_2;
        $track2 = $this->createObject($rsv, 'Security accept the request', $condition2, 'Security', $rsv->sign_approval_2);
        $objects[] = $track2;

        $condition3 = $rsv->sign_approval_3;
        $track3 = $this->createObject($rsv, 'Wating for payment', $condition3, $user, $rsv->sign_approval_3);
        $objects[] = $track3;

        if ($ticket->RequestReservation->is_deposit) {
            $condition4 = $rsv->sign_approval_5;
            $track4 = $this->createObject($rsv, 'Payment is confirmed and success', $condition4, 'System', $rsv->sign_approval_5);
            $objects[] = $track4;
        }

        $condition5 = $rsv->sign_approval_4;
        $track5 = $this->createObject($rsv, 'Reservation is Done', $condition5, $user, $rsv->updated_at);
        $objects[] = $track5;

        $condition6 = $rsv->sign_approval_4;
        $track6 = $this->createObject($rsv, 'Reservation is Completed', $condition6, 'Building Manager', $ticket->updated_at);
        $objects[] = $track6;

        return $objects;
    }

    function trackPermit($ticket, $objects)
    {
        $wp = $ticket->WorkPermit;
        $user = $ticket->Tenant->user->nama_user;

        $condition1 = $wp->sign_approval_1;
        $track1 = $this->createObject($wp, 'Tenant accept payment', $condition1, $user, $wp->sign_approval_1);
        $objects[] = $track1;

        $condition2 = $wp->sign_approval_2;
        $track2 = $this->createObject($wp, 'Management accept request', $condition2, $wp->WorkRelation->work_relation, $wp->sign_approval_2);
        $objects[] = $track2;

        $condition3 = $wp->sign_approval_3;
        $track3 = $this->createObject($wp, 'Finance accept request', $condition3, 'Finance', $wp->sign_approval_3);
        $objects[] = $track3;

        $condition4 = $ticket->Cashreceipt;
        $track4 = $this->createObject($wp, 'Wating for payment', $condition4,  'System', $ticket->CashReceipt->created_at);
        $objects[] = $track4;

        $condition4 = $wp->status_bayar == 'PAID';
        $track4 = $this->createObject($wp, 'Payment is confirmed and success', $condition4,  'System', $wp->sign_approval_5);
        $objects[] = $track4;

        $condition4 = $wp->sign_approval_4;
        $track4 = $this->createObject($wp, 'Request has been approved', $condition4,  'Building Management', $wp->sign_approval_4);
        $objects[] = $track4;

        $condition5 = $wp->sign_approval_4 && ($ticket->status_request != 'DONE' || $ticket->status_request != 'COMPLETE');
        $track5 = $this->createObject($wp, 'Request has been worked', $condition5,  $wp->WorkRelation->work_relation, $wp->sign_approval_4);
        $objects[] = $track5;

        $condition6 = $wp->BAPP;
        $track6 = $this->createObject($wp, 'Request has Done', $condition6,  $wp->WorkRelation->work_relation, $wp->BAPP->created_at);
        $objects[] = $track6;

        $track7 = $this->createObject($wp, 'Waiting for returning Deposit', $condition6,  $user, $wp->BAPP->created_at);
        $objects[] = $track7;

        $condition7 = $wp->BAPP->status_pengembalian = 1;
        $track8 = $this->createObject($wp, 'Deposit hasn been returned', $condition7, $user, $wp->BAPP->sign_approval_1);
        $objects[] = $track8;

        $condition8 = $ticket->status_request = 'COMPLETE';
        $track9 = $this->createObject($wp, 'Request hasn been Complete', $condition8, 'Building Manager', $ticket->updated_at);
        $objects[] = $track9;

        return $objects;
    }

    function trackComplaint($ticket, $objects)
    {
        $wr = $ticket->WorkRequest;
        $wo = $ticket->WorkRequest->WorkOrder;
        $user = $ticket->Tenant->nama_tenant;

        if ($wr) {
            $work_relation = $wr->WorkRelation->work_relation;

            $condition1 = $wr;
            $track1 = $this->createObject($wr, 'Request processed to Work Request', $condition1, $work_relation, $wr->created_at);
            $objects[] = $track1;

            $condition2 = $wr->date_approval_1;
            $track2 = $this->createObject($wr, 'Work Request has been approved and progress on working', $condition2, $work_relation, $wr->created_at);
            $objects[] = $track2;

            $condition3 = ($wr->status_request == 'WORK DONE' || $wr->status_request == 'DONE' || $wr->status_request == 'COMPLETE') && !$wr->WorkORder;
            if ($condition3) {
                $condition3 = $condition3;
                $track3 = $this->createObject($wr, 'Work Request has finished', $condition3, $work_relation, $wr->created_at);
                $objects[] = $track3;

                $condition4 = ($wr->status_request == 'DONE' || $wr->status_request == 'COMPLETE') && !$wr->WorkORder;
                $track4 = $this->createObject($wr, 'Work Request has finished by tenant', $condition4, $user, $wr->updated_at);
                $objects[] = $track4;

                $condition4 = $wr->status_request == 'COMPLETE' && !$wr->WorkORder;
                $track5 = $this->createObject($wr, 'Work Request has Completed', $condition4, 'Building Manager', $wr->updated_at);
                $objects[] = $track5;
            } else {
                $condition5 = $wo;
                $track6 = $this->createObject($wo, 'Work Request processed to Work Order', $condition5, $work_relation, $wr->updated_at);
                $objects[] = $track6;

                $condition6 = $wo->sign_approve_1;
                $track7 = $this->createObject($wo, 'Work Request has approved by Tenant', $condition6, $user, $wo->date_approve_1);
                $objects[] = $track7;

                $condition7 = $wo->sign_approve_2;
                $track8 = $this->createObject($wo, 'Work Request has approved by Managamenet', $condition7, $work_relation, $wo->date_approve_2);
                $objects[] = $track8;

                $condition7 = $wo->sign_approve_2 && $wo->status_request;
                $track8 = $this->createObject($wo, 'Work Request has approved by Managamenet', $condition7, $work_relation, $wo->date_approve_2);
                $objects[] = $track8;
            }
        }




        return $objects;
    }
}
