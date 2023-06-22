<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HKKoridor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_hk_koridor';
    protected $primaryKey = 'id_hk_koridor';

    protected $fillable = [
        'id_hk_koridor',
        'nama_hk_koridor',
        'subject',
        'periode',
    ];
    protected $dates = ['deleted_at'];
}
