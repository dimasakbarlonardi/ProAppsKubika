<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_attendance';

    protected $fillable = [
        'id_site',
        'id_user',
        'check_in',
        'check_out',
        'work_hour',
        'status',
        'status_absence',
    ];

    protected $dates = ['deleted_at'];
}
