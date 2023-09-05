<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsEngineering extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tb_tools_engineering';
    
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

    public function User()
    {
        return $this->belongsTo(Login::class, 'id', 'id_user'); 
    }
}
