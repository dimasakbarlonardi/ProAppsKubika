<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestPermitDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_request_permit_d';

    protected $fillable = [
        'no_tiket',
        'data'
    ];

    protected $dates = ['deleted_at'];
}
