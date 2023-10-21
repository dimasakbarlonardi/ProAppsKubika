<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitAttendance extends Model
{
    use HasFactory;

    protected $table = 'tb_permit_attendance';

    public function Karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'karyawan_id');
    }

    public function WorkTimeline($date)
    {
        return $this->hasOne(WorkTimeline::class, 'karyawan_id', 'karyawan_id')
            ->where('date', $date)
            ->first();
    }
}
