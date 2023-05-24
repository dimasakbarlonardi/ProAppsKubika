<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangReservation extends Model
{
    use HasFactory;

    protected $table = 'tb_ruang_reservation';
    protected $primaryKey = 'id_ruang_reservation';

    protected $fillable = [
        
    ];
}
