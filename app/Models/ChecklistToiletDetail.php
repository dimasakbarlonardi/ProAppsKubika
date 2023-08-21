<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistToiletDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_toilet_d';
    protected $primaryKey = 'id_eng_toilet';

    protected $fillable = [
        'id_eng_toilet',
        'no_checklist_toilet',
        'id_equiqment',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];

    public function checklisttoilet()
    {
        return $this->hasOne(ChecklistParameterEquiqment::class, 'id_equiqment', 'id_equiqment');
    }
}
