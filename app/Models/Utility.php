<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utility extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $table = 'tb_utility';

    protected $primaryKey = 'id_utility';

    protected $fillable = [
        'id_utility',
        'nama_utility',
        'biaya_admin',
        'biaya_abodemen',
        'biaya_tetap',
        'biaya_m3',
        'biaya_pju',
        'biaya_ppj',

    ];

    protected $dates = ['deleted_at'];
}
