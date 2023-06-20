<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'tb_work_order_d';

    protected $fillable = [
        'no_work_order',
        'detil_pekerjaan',
        'detil_biaya_alat',
        'detil_jasa'
    ];
}
