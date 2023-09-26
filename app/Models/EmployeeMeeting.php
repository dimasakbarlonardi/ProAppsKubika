<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeMeeting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_employee_meeting';

    protected $primaryKey = 'id';

    protected $fillable  = [
        'id',
        'id_karyawan',
        'id_meeting',
    ];

    protected $dates = ['deleted_at'];

    public function Karyawan()
    {
        return $this->hasOne( Karyawan::class, 'id' , 'id_karyawan');
    }

    public function Meeting()
    {
        return $this->hasOne( ScheduleMeeting::class, 'id', 'id_meeting');
    }
}
