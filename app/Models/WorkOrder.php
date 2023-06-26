<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_work_order';

    protected $fillable = [
        'no_work_order',
        'no_tiket',
        'no_work_request',
        'tgl_work_order',
        'id_bayarnon',
        'tgl_bayar_wo',
        'jumlah_bayar_wo',
        'no_cash_receipt',
        'id_division',
        'estimasi_pengerjaan',
        'jadwal_pengerjaan',
        'id_user_wo',
        'id_user_mgr',
        'status_wo',
        'sign_approve_1',
        'sign_approve_2',
        'sign_approve_3',
        'sign_approve_4',
        'sign_approval_5',
        'date_approve_1',
        'date_approve_2',
        'date_approve_3',
        'date_approve_4',
        'date_approval_5',
    ];

    protected $dates = ['deleted_at'];

    public function WorkRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'no_work_request', 'no_work_request');
    }

    public function Ticket()
    {
        return $this->belongsTo(OpenTicket::class, 'no_tiket', 'no_tiket');
    }

    public function WODetail()
    {
        return $this->hasMany(WorkOrderDetail::class, 'no_work_order', 'no_work_order');
    }
}
