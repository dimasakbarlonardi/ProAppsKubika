<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngPAM extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_pam';
    protected $primaryKey = 'id_eng_pam';

    protected $fillable = [
        'id_eng_pam',
        'nama_eng_pam',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
