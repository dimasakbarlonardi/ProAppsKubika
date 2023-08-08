<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\JenisRequest;
use App\Models\OpenTicket;
use App\Models\System;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OpenTicketController extends Controller
{
    public function listTickets(Request $request)
    {
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', $request->user()->email)->first();
        $tickets = $connOpenTicket->where('id_user', $user->id_user)->get();

        return ResponseFormatter::success([
            $tickets
        ], 'Berhasil mengambil semua tickets');
    }
    public function jenisRequest(Request $request)
    {
        $connJenisReq = ConnectionDB::setConnection(new JenisRequest());

        $jenis_requests = $connJenisReq->get();

        return ResponseFormatter::success([
            $jenis_requests
        ], 'Berhasil mengambil jenis request');
    }

    public function store(Request $request)
    {
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());

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
            $createTicket->id_user = $unit->TenantUnit->Tenant->User->id_user;
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

            return ResponseFormatter::success([
                $createTicket
            ], 'Berhasil membuat ticket');
        } catch (Throwable $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal membuat ticket');
        }
    }

    public function show($id, Request $request)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        $ticket = $connRequest->where('id', $id)->with('User')->first();
        $ticket->deskripsi_request = strip_tags($ticket->deskripsi_request);
        $ticket->deskripsi_respon = strip_tags($ticket->deskripsi_respon);

        return ResponseFormatter::success([
            $ticket
        ], 'Berhasil mengambil request');
    }
}