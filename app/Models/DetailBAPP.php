<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBAPP extends Model
{
    use HasFactory;

    protected $table = 'tb_bapp_d';

    protected $fillable = [
        'no_bapp',
        'id_eng_bapp',
        'catatan'
    ];
}
