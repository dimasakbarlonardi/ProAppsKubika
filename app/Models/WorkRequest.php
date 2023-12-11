<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_work_request';

    protected $fillable = [
        'no_tiket',
        'deskripsi_wr',
        'status_request',
        'no_work_request',
        'id_work_relation',
        'schedule',
        'is_working',
        'is_worked',
        'sign_approve_1',
        'sign_approval_2',
        'sign_approval_3',
        'date_approve_2',
        'date_approval_2',
        'date_approval_3',
    ];

    protected $dates = ['deleted_at'];

    public function workRelation()
    {
        return $this->hasOne(WorkRelation::class, 'id_work_relation', 'id_work_relation');
    }

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_tiket', 'no_tiket');
    }

    public function workOrder()
    {
        return $this->hasOne(WorkOrder::class, 'no_work_request', 'no_work_request');
    }
}
