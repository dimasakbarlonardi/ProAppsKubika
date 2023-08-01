<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PPN extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_ppn';
    protected $primaryKey = 'id_ppn';

    protected $fillable = [
        'id_ppn',
        'nama_ppn',
        'biaya_procentage',
    ];

    protected $dates = ['deleted_at'];
}
