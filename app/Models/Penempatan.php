<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penempatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_penempatan';
    protected $primaryKey = 'id_penempatan';
    public $incrementing = false;

    protected $fillable = [
        'id_penempatan',
        'lokasi_penempatan',
    ];
    protected $dates = ['deleted_at'];
}
