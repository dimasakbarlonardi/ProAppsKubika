<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsHousekeeping extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_tools_housekeeping';

    protected $primaryKey = 'id';

    protected $fillable =[
        'id',
        'name_tools',
        'status',
        'total_tools',
        'borrow',
        'date_in',
        'date_out,',
        'current_totals',
        'id_user',
        'unity'
    ];

    protected $dates = ['deleted_at'];
}
