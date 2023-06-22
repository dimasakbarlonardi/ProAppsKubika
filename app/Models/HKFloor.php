<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HKFloor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_hk_floor';
    protected $primaryKey = 'id_hk_floor';

    protected $fillable = [
        'id_hk_floor',
        'nama_hk_floor',
        'subject',
        'periode',
    ];
    protected $dates = ['deleted_at'];
}
