<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermitHR extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tb_permit';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name_permit'
    ];

    protected $dates = ['deleted_at'];
}
