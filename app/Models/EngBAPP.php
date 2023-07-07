<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngBAPP extends Model
{
    use HasFactory;

    protected $table = 'tb_eng_bapp';

    protected $fillable = [
        'nama_eng_bapp',
        'subject',
        'dsg'
    ];
}
