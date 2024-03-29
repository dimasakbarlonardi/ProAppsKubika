<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeReservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_type_reservation';
    protected $primaryKey = 'id_type_reservation';

    protected $fillable = [
        'id_type_reservation',
        'type_reservation',
    ];

    protected $dates = ['deleted_at'];
}
