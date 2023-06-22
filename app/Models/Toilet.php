<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toilet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_toilet';
    protected $primaryKey = 'id_hk_toilet';

    protected $fillable = [
        'id_hk_toilet',
        'nama_hk_toilet',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
