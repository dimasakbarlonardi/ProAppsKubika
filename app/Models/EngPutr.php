<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngPutr extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_putr';
    protected $primaryKey = 'id_eng_putr';

    protected $fillable = [
        'id_eng_putr',
        'nama_eng_putr',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
