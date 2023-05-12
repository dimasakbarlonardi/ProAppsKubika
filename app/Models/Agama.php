<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;

    protected $table =  'tb_agama';
    protected $primryKey = 'id_agama';

    protected $fillable = [
        'id_agama',
        'nama_agama'
    ];
}
