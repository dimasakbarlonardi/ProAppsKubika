<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquiqmentEngineeringDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_equiqment_engineering_detail';

    protected $primaryKey = 'id_equiqment_engineering_detail';

    protected $fillabel = [
        'id_equiqment_engineering_detail',
        'id_equiqment_engineering',
        'no_checklist',
        'id_equiqment',
        'tgl_checklist',
        'time_checklist',
        'usage_return',
        'keterangan'
    ];

    protected $dates = ['deleted_at'];

    public function equiqment()
    {
        return $this->hasOne(ChecklistAhuH::class, 'id_equiqment_ahu', 'id_equiqment_ahu');
    }
    
}
