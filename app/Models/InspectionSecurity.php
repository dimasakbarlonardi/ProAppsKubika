<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionSecurity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_security';
    protected $primaryKey = 'id_security';

    protected $fillable = [
        'id_security',
        'id_guard',
        'checkpoint_name',
        'tgl_patrol',
    ];

    protected $dates = ['deleted_at'];
}
