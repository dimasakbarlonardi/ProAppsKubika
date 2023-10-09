<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyUtility extends Model
{
    use HasFactory;

    protected $table = 'tb_fin_monthly_utility';

    public function MonthlyTenant()
    {
        return $this->hasOne(MonthlyArTenant::class, 'id_monthly_utility', 'id');
    }

    public function ElectricUUS()
    {
        return $this->hasOne(ElectricUUS::class, 'id', 'id_eng_listrik');
    }

    public function WaterUUS()
    {
        return $this->hasOne(WaterUUS::class, 'id', 'id_eng_air');
    }

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }
}
