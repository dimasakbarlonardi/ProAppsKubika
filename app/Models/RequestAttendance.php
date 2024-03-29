<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestAttendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_request_attendance';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_request_type',
        'date_in',
        'date_out',
        'status'
    ];

    protected $dates = ['deleted_at'];

    public function RequestType()
    {
        return $this->hasOne(RequestType::class, 'id', 'id_request_type');
    }
}
