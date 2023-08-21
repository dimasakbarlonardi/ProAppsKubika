<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionEngineering extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_inspection_engineering';

    protected $primaryKey = 'id_inspection_engineering';

    protected $fillable = [
        'id_inspection_engineering',
        'inspection_engineering',
        'id_equiqment_engineering'
    ];

    protected $dates = ['deletes_at'];
}
