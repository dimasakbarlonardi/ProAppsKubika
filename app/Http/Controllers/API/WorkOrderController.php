<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\System;
use App\Models\WorkOrder;
use App\Models\CashReceipt;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;


class WorkOrderController extends Controller
{
    public function show($id)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->where('id', $id)
        ->with(['Ticket', 'WODetail'])
        ->first();

        return ResponseFormatter::success(
            $wo,
            'Success get WO'
        );
    }

    public function acceptWO($id)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->find($id);

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_1 = '1';
        $wo->date_approve_1 = Carbon::now();
        $wo->save();

        $createTransaction = $this->createTransaction($wo);

        HelpNotifikasi::paymentWO($id, $createTransaction);

        return ResponseFormatter::success(
            $wo,
            'Success approve WO'
        );
    }

    public function createTransaction($wo)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());

        $system = $connSystem->find(1);
        $request = Request();
        $user = $request->user();

        $count = $system->sequence_no_cash_receiptment + 1;
        $countINV = $system->sequence_no_invoice + 1;

        $no_cr = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_cash_receipt . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $no_inv = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countINV);

        $order_id = $user->id_site . '-' . $no_cr;

        try {
            DB::beginTransaction();

            $createTransaction = $connTransaction;
            $createTransaction->order_id = $order_id;
            $createTransaction->id_site = $user->id_site;
            $createTransaction->no_reff = $wo->no_work_order;
            $createTransaction->no_draft_cr = $no_cr;
            $createTransaction->ket_pembayaran = 'WO/' . $wo->Ticket->Tenant->User->id_user . '/' . $wo->Ticket->Unit->nama_unit;
            $createTransaction->sub_total = $wo->jumlah_bayar_wo;
            $createTransaction->no_invoice = $no_inv;
            $createTransaction->transaction_status = 'PENDING';
            $createTransaction->id_user = $wo->Ticket->Tenant->User->id_user;
            $createTransaction->transaction_type = 'WorkOrder';
            $createTransaction->save();

            $system->sequence_no_cash_receiptment = $count;
            $system->sequence_no_invoice = $countINV;

            $createTransaction->WorkOrder->Ticket->no_invoice = $no_inv;
            $createTransaction->WorkOrder->Ticket->save();

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
