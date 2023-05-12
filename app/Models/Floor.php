<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_nolantai';
    protected $primaryKey = 'id_lantai';
    public $incrementing = false;

    protected $fillable = [
        'id_lantai',
        'nama_lantai'
    ];

    protected $dates = ['deleted_at'];
}
