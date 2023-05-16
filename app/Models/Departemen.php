<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departemen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_departemen';
    protected $primaryKey = 'id_departemen';
    public $incrementing = false;

    protected $fillable = [
        'id_departemen',
        'nama_departemen',
    ];
    protected $dates = ['deleted_at'];
}
