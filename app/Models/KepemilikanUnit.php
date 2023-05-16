<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KepemilikanUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_pemilik_d';
    protected $primaryKey = 'id_kepemilikan_unit';
    // public $incrementing = false;

    protected $fillable = [
        'id_kepemilikan_unit ',
        'id_pemilik',
        'id_unit',
        'id_status_hunian',
    ];

    protected $date = ['deleted_at'];
}
