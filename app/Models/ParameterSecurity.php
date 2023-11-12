<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParameterSecurity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_parameter_security';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name_parameter_security',

    ];
    
    protected $dates = ['deleted_at'];
}
