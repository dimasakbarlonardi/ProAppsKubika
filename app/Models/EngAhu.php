<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngAhu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_ahu';
    protected $primaryKey = 'id_eng_ahu';

    protected $fillable = [
        'id_eng_ahu',
        'nama_eng_ahu',
    ];
    protected $dates = ['deleted_at'];

    public function checklist()
    {
        return $this->hasOne(ChecklistParameterEquiqment::class, 'id_checklist', 'id_eng_ahu');
    }
}
