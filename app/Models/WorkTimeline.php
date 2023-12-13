<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkTimeline extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'tb_work_timeline';

    protected $fillable = [
        'id',
        'karyawan_id',
        'shift_type_id',
        'date',
        'status_absence',
        'check_in',
        'check_out',
        'checkin_lat',
        'checkin_long',
        'work_hour',
        'checkin_photo',
        'checkout_photo'
        
    ];

    protected $dates = ['deleted_at'];

    public function Karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'karyawan_id');
    }

    public function ShiftType()
    {
        return $this->hasOne(ShiftType::class, 'id', 'shift_type_id');
    }
}
