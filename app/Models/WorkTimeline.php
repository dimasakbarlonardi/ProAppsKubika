<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTimeline extends Model
{
    use HasFactory;

    protected $table = 'tb_work_timeline';

    public function Karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'karyawan_id');
    }

    public function ShiftType()
    {
        return $this->hasOne(ShiftType::class, 'id', 'shift_type_id');
    }
}
