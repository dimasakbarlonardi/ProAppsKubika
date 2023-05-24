<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_status_request';
    protected $primaryKey = 'id_status_request';    

    protected $fillable = ([
        'id_status_request',
        'status_request',
    ]);

    protected $dates = ['deleted_at'];
}
