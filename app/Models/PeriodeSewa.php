<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodeSewa extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'tb_periode_sewa';
    protected $primaryKey = 'id_periode_sewa';
    public $incrementing = false;

    protected $fillable = [
        'id_periode_sewa',
        'periode_sewa'
    ];
    
    protected $dates = ['deleted_at'];
}
