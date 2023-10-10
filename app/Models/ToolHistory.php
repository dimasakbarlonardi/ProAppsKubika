<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolHistory extends Model
{
    use HasFactory;

    protected $table = 'tb_tools_history';

    protected $fillable = [
        'type',
        'id_data',
        'qty',
        'borrowed_by',
        'status',
        'action'
    ];

    public function EngTool()
    {
        return $this->hasOne(ToolsEngineering::class, 'id', 'id_data');
    }

    public function HKTool()
    {
        return $this->hasOne(ToolsHousekeeping::class, 'id', 'id_data');
    }
}
