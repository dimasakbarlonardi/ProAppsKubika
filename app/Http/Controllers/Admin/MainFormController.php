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
        $object1->title = 'Request GIGO accepted by TR ';
        $object1->status_time = $ticket->status_respon == 'Responded' ? $ticket->tgl_respon_tiket . ' ' . $ticket->jam_respon : null;
        $object1->icon = null;
        $object1->user = $ticket->status_respon ? $ticket->ResponseBy->nama_user : null;
        $objects[] = $object1;

        switch ($ticket->id_jenis_request) {
            case 5:
                $objects = $this->trackGIGO($ticket, $objects);
                break;
        }

        $data['data'] = $objects;

        return response()->json([
            'html' => view('AdminSite.TrackingTicket.track-index', $data)->render(),
            'objects' => $objects
        ]);
    }

    function trackGIGO($ticket, $objects)
    {
        $object = new stdClass();
        $object->is_done = $ticket->RequestGIGO ? ($ticket->requestGIGO->sign_approval_2 ? true : false) : false;
        $object->title = 'Request GIGO accepted by Security ';
        $object->status_time = $ticket->RequestGIGO ? ($ticket->requestGIGO->sign_approval_2 ? $ticket->requestGIGO->sign_approval_2 : null) : null;
        $object->icon = null;
        $object->user = $ticket->RequestGIGO ? ($ticket->requestGIGO->sign_approval_2 ? 'Security' : null) : null;;
        $objects[] = $object;

        $object2 = new stdClass();
        $object2->is_done = $ticket->RequestGIGO ? ($ticket->requestGIGO->status_request == 'DONE' || $ticket->requestGIGO->status_request == 'COMPLETE' ? true : false) : false;
        $object2->title = 'Request GIGO has done';
        $object2->status_time = $ticket->RequestGIGO ? ($ticket->requestGIGO->status_request ? $ticket->requestGIGO->sign_approval_2 : null) : null;
        $object2->icon = null;
        $object2->user = $ticket->RequestGIGO ? ($ticket->requestGIGO->status_request == 'DONE' || $ticket->requestGIGO->status_request == 'COMPLETE' ? $ticket->Tenant->user->nama_user : null) : null;
        $objects[] = $object2;

        $object3 = new stdClass();
        $object3->is_done = $ticket->RequestGIGO ? ($ticket->requestGIGO->status_request == 'COMPLETE' ? true : false) : false;
        $object3->title = 'Request GIGO has complete';
        $object3->status_time = $ticket->RequestGIGO ? ($ticket->requestGIGO->sign_approval_3 ? $ticket->requestGIGO->sign_approval_3 : null) : null;
        $object3->icon = null;
        $object3->user = $ticket->RequestGIGO ? ($ticket->requestGIGO->sign_approval_3 ? 'Building Manager' : null) : null;
        $objects[] = $object3;

        return $objects;
    }
}
