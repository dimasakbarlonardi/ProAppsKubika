<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngDeepWheel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_deepwheel';
    protected $primaryKey = 'id_eng_deep';

    protected $fillable = [
        'id_eng_deep',
        'nama_eng_deep',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
