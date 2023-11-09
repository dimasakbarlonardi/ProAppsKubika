<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyIPL extends Model
{
    use HasFactory;

    protected $table = 'tb_fin_monthly_ipl';

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }
}
