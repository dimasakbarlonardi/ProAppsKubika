<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = "tb_visitor";

    protected $primaryKey = "id";

    protected $fillable = [
    'id',
    'name_visitor',
    'unit_id',
    'arrival_date',
    'arrival_time',
    'leave_time',
    'leave_date',
    'heading_to',
    'desc',
    'status',
    'leave_date',
    'leave_time'
    ];

    protected $dates = ['deleted_at'];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'unit_id');
    }
}
