<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsSecurity extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tb_tools_security';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name_tools',
        'status',
        'total_tools',
        'borrow',
        'date_in',
        'date_out,',
        'current_totals',
        'id_user'
    ];

    protected $dates = ['deleted_at'];
}
