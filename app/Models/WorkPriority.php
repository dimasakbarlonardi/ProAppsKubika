<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkPriority extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'tb_work_priority';
    protected $primaryKey = 'id_work_priority';

    protected $fillable = [
        'id_work_priority',
        'work_priority',
    ];

    protected $dates = ['deleted_at'];
}
