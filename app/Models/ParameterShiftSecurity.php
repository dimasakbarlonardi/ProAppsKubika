<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParameterShiftSecurity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_parameter_shift_security';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'shift',
        'start_time',
        'end_time',
    ];

    protected $dates = ['deleted_at'];
}
