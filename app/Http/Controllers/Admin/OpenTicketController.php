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

            $data['tickets'] = $connRequest->where('id_tenant', $tenant->id_tenant)->get();
        } else {
            $data['tickets'] = $connRequest->get();
        }

        $data['user'] = $user;

        return view('AdminSite.OpenTicket.index', $data);
    }

    public function create(Request $request)
    {
        $user = $request->session()->get('user');
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $connTU = ConnectionDB::setConnection(new TenantUnit());

        $getTenant = $connTenant->where('email_tenant', $user->login_user)->first();
        $data['units'] = $connTU->where('id_tenant', $getTenant->id_tenant)->get();

        return view('AdminSite.OpenTicket.create', $data);
    }

    public function store(Request $request)
    {
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $user = $request->session()->get('user');
        $site = Site::find($user->id_site);
        $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
        $system = $connSystem->find(1);
        $count = $connOpenTicket->count() + 1;

        $unit = $connUnit->find($request->id_unit);

        $nowDate = Carbon::now();

        try {
            $unit = $connUnit->find($request->id_unit);

            DB::beginTransaction();
            $no_tiket = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_tiket . '/' .
                Carbon::now()->format('m') . $nowDate->year . '/' .
                sprintf("%06d", $count);

            $createTicket = $connOpenTicket->create($request->all());

            $file = $request->file('upload_image');
            $fileName = $createTicket->id . '-' .   $file->getClientOriginalName();
            $file->move('uploads/image/ticket', $createTicket->id . '-' .  $fileName);

            $createTicket->id_tenant = $tenant->id_tenant;
            $createTicket->id_site = $site->id_site;
            $createTicket->id_tower = $unit->tower->id_tower;
            $createTicket->id_lantai = $unit->floor->id_lantai;
            $createTicket->no_tiket = $no_tiket;
            $createTicket->upload_image = $fileName;
            $createTicket->status_request = 'PENDING';
            $createTicket->save();

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
        $connWorkPrior = ConnectionDB::setConnection(new WorkPriority());
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());

        $ticket = $connRequest->find($id);
        $user = $request->session()->get('user');

        $data['work_priorities'] = $connWorkPrior->get();
        $data['jenis_requests'] = $connJenisReq->get();
        $data['work_relations'] = $connWorkRelation->get();
        $data['ticket'] = $ticket;
        $data['user'] = $user;

        return view('AdminSite.OpenTicket.show', $data);
    }

    public function update(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();
            $ticket = $connRequest->find($id);
            $ticket->status_request = $request->status_request;
            $ticket->id_jenis_request = $request->id_jenis_request;
            $ticket->tgl_respon_tiket = Carbon::now()->format('Y-m-d');
            $ticket->jam_respon = Carbon::now()->format('H:i');
            $ticket->id_user_resp_request = $user->id_user;

            $ticket->save();
        } catch (Throwable $e) {
            dd($e);
            Alert::error('Gagal', 'Gagal mengupdate tiket');

            return redirect()->back();
        }

        Alert::success('Berhasil', 'Berhasil mengupdate tiket');

        return redirect()->back();
    }
}
