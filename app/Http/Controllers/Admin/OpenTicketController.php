<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\JenisRequest;
use App\Models\Login;
use App\Models\OpenTicket;
use App\Models\Site;
use App\Models\System;
use App\Models\Tenant;
use App\Models\TenantUnit;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkPriority;
use App\Models\WorkRelation;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class OpenTicketController extends Controller
{
    public function index(Request $request)
    {
        $login = Auth::user()->id;
        $user = $request->session()->get('user');

        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        if ($user->user_category == 3) {
            $tenant = $connTenant->where('id_user', $login)->first();

            $data['tickets'] = $connRequest->where('id_tenant', $tenant->id_tenant)->latest()->get();
        } else {
            $data['tickets'] = $connRequest->latest()->get();
        }

        $data['user'] = $user;

        return view('AdminSite.OpenTicket.index', $data);
    }

    public function create(Request $request)
    {
        $user = $request->session()->get('user');
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $connTU = ConnectionDB::setConnection(new TenantUnit());
        $connJenisReq = ConnectionDB::setConnection(new JenisRequest());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        if ($user->user_category == 2) {
            $data['units'] = $connTU->get();
            $data['tenants'] = $connTenant->get();
        } else {
            $getTenant = $connTenant->where('email_tenant', $user->login_user)->first();
            $data['units'] = $connTU->where('id_tenant', $getTenant->id_tenant)->get();
        }

        $data['user'] = $user;
        $data['jenis_requests'] = $connJenisReq->get();

        return view('AdminSite.OpenTicket.create', $data);
    }

    public function store(Request $request)
    {
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        // $user = $request->session()->get('user');
        // $site = Site::find($user->id_site);

        // $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
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
            $createTicket->id_site = $unit->id_site;
            $createTicket->id_tower = $unit->id_tower;
            $createTicket->id_unit = $request->id_unit;
            $createTicket->id_lantai = $unit->id_lantai;
            $createTicket->id_tenant = $unit->TenantUnit->id_tenant;
            $createTicket->no_tiket = $no_tiket;
            $createTicket->status_request = 'PENDING';

            $file = $request->file('upload_image');

            if ($file) {
                $fileName = $createTicket->id . '-' .   $file->getClientOriginalName();
                $file->move('uploads/image/ticket', $fileName);
                $createTicket->upload_image = $fileName;
            }

            $createTicket->save();
            $system->sequence_notiket = $count;
            $system->save();

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan request');

            return redirect()->route('open-tickets.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Error', $e);

            return redirect()->route('open-tickets.create');
        }
    }

    public function show(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connJenisReq = ConnectionDB::setConnection(new JenisRequest());

        $ticket = $connRequest->where('id', $id)->with('Tenant')->first();
        $user = $request->session()->get('user');

        $data['jenis_requests'] = $connJenisReq->get();
        $data['ticket'] = $ticket;
        $data['user'] = $user;

        if ($request->data_type == 'json') {
            return response()->json(['data' => $ticket]);
        } else {
            return view('AdminSite.OpenTicket.show', $data);
        }
    }

    public function update(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        try {
            DB::beginTransaction();
            $ticket = $connRequest->find($id);
            $ticket->status_request = $request->status_request;
            $ticket->id_jenis_request = $request->id_jenis_request;

            $ticket->save();
        } catch (Throwable $e) {
            dd($e);
            Alert::error('Gagal', 'Gagal mengupdate tiket');

            return redirect()->back();
        }

        Alert::success('Berhasil', 'Berhasil mengupdate tiket');

        return redirect()->back();
    }

    public function updateRequestTicket(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $user = $request->session()->get('user');

        $ticket = $connRequest->find($id);
        $ticket->status_respon = 'Responded';
        $ticket->status_request = 'RESPONDED';
        $ticket->tgl_respon_tiket = Carbon::now()->format("Y-m-d");
        $ticket->jam_respon = Carbon::now()->format("H:i");
        $ticket->deskripsi_respon = $request->deskripsi_respon;
        $ticket->id_user_resp_request = $user->id_user;
        $ticket->save();

        Alert::success('Berhasil', 'Berhasil merespon tiket');

        return redirect()->back();
    }
}
