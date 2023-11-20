<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistParameterEquiqment extends Model
{
    use HasFactory;

    protected $table = 'tb_checklist_equiqment_parameter';
    protected $primaryKey = 'id_checklist_equiqment_parameter';

    protected $fillable = [
        'id_checklist_equiqment_parameter',
        'id_item',
        'id_checklist',
        'id_equiqment'
    ];
    protected $dates = ['deleted_at'];

    public function ChecklistEng()
    {
        return $this->hasOne(EngAhu::class, 'id_eng_ahu', 'id_checklist');
    }

     public function ChecklistSec()
    {
        return $this->hasOne(ParameterSecurity::class, 'id', 'id_checklist');
    }

    public function ChecklistHK()
    {
        return $this->hasOne(Toilet::class, 'id_hk_toilet', 'id_checklist');
    }

    public function checklistahu()
    {
        return $this->hasOne(ChecklistAhuDetail::class, 'id_equiqment', 'id_equiqment');
    }
}
