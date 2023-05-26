<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusKawin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_status_kawin';
    protected $primaryKey = 'id_status_kawin';

    protected $fillable = [
        'id_status_kawin',
        'status_kawin',
    ];
    protected $dates = ['deleted_at'];
}