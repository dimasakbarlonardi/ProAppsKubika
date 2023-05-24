<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuangReservation extends Model
{
    use HasFactory;

    protected $table = 'tb_ruang_reservation';
    protected $primaryKey = 'id_ruang_reservation';

    protected $fillable = [
        'id_ruang_reservation',
        'ruang_reservation',
    ];

    protected $dates = ['deleted_at'];
}
