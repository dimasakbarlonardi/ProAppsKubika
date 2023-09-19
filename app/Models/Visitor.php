<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = "tb_visitor";

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'unit_id');
    }
}
