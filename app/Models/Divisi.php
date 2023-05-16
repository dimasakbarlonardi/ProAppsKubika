<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divisi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_divisi';
    protected $primaryKey = 'id_divisi';
    public $incrementing = false;

    protected $fillable = [
        'id_divisi',
        'nama_divisi',
    ];
    protected $dates = ['deleted_at'];
}
