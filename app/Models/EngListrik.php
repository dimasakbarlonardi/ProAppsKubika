<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngListrik extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_listrik';
    protected $primaryKey = 'id_eng_listrik';

    protected $fillable = [
        'id_eng_listrik',
        'nama_eng_listrik',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
