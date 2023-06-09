<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerhitDenda extends Model
{
    use HasFactory;

    protected $table = 'tb_perhit_denda';
    protected $primaryKey = 'id_perhit_denda';

    protected $fillable = [
        'id_perhit_denda',
        'jenis_denda',
        'denda_flat_procetage',
        'denda_flat_amount',
    ];

    protected $dates = ['deleted_at'];
}
