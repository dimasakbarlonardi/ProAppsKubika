<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermitAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_permit_attendance';

    public function Karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'karyawan_id');
    }

    public function Replacement()
    {
        return $this->hasOne(Karyawan::class, 'id', 'replacement_id');
    }

    public function CurrentShift()
    {
        return $this->hasOne(ShiftType::class, 'id', 'previous_shift_id');
    }

    public function RequestShift()
    {
        return $this->hasOne(ShiftType::class, 'id', 'replace_shift_id');
    }

    public function WorkTimeline($date)
    {
        return $this->hasOne(WorkTimeline::class, 'karyawan_id', 'karyawan_id')
            ->where('date', $date)
            ->first();
    }
}
