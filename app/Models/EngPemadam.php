<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngPemadam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_pemadam';
    protected $primaryKey = 'id_eng_pemadam';

    protected $fillable = [
        'id_eng_pemadam',
        'nama_eng_pemadam',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
