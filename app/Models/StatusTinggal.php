<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusTinggal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_statustinggal_tenant';
    protected $primaryKey = 'id_status_tinggal';
    public $incrementing = false;

    protected $fillable = [
        'id_status_tinggal',
        'status_tinggal',
    ];
    protected $dates = ['deleted_at'];
}
