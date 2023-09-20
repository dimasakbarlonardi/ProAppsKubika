<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_shift_type';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'shift',
        'checkin',
        'checkout'
    ];

    protected $dates = ['deleted_at'];
}
