<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IPLType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_ipl_type';
    protected $fillabel = [
        'id_ipl_type',
        'nama_ipl_type',
        'biaya_permeter',
        'biaya_procentage',
    ];

    protected $dates = ['deleted_at'];
}
