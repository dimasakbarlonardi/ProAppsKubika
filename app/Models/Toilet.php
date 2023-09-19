<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toilet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_toilet';
    protected $primaryKey = 'id_hk_toilet';

    protected $fillable = [
        'id_hk_toilet',
        'nama_hk_toilet',
    ];
    protected $dates = ['deleted_at'];

    public function checklist()
    {
        return $this->hasOne(ChecklistParameterEquiqment::class, 'id_checklist', 'id_hk_toilet');
    }

    public function checklistParameters()
    {
        return $this->hasMany(ChecklistParameterEquiqment::class, 'id_checklist', 'id_hk_toilet');
    }

}
