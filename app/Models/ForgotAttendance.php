<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForgotAttendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_forgot_attendance';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'forgot_type',
    ];
    protected $dates = ['deleted_at'];
    
}
