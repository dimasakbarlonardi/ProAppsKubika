<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lift extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_hk_lift';
    protected $primaryKey = 'id_hk_lift';

    protected $fillable = [
        'id_hk_lift',
        'nama_hk_lift',
        'subject',
        'periode',
    ];
    protected $dates = ['deleted_at'];
}
