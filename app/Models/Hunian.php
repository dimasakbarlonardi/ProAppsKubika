<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hunian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_hunian';
    protected $primaryKey = 'id_hunian';
    public $incrementing = false;

    protected $fillable = [
        'id_hunian',
        'nama_hunian',
    ];
}
