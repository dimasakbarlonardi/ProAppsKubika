<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BayarNon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_bayarnon';
    protected $primaryKey = 'id_bayarnon';

    protected $fillable = [
        'id_bayarnon',
        'bayarnon',
    ];

    protected $dates = ['deleted_at'];
}
