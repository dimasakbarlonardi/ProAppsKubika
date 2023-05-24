<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agama extends Model
{
    use HasFactory, SoftDeletes;

    protected $table =  'tb_agama';
    protected $primaryKey = 'id_agama';

    protected $fillable = [
        'id_agama',
        'nama_agama'
    ];

    protected $dates = ['deleted_at'];
}
