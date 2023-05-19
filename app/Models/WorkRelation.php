<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkRelation extends Model
{
    use HasFactory,  SoftDeletes;

    protected $table = 'tb_work_relation';
    protected $primaryKey = 'id_work_relation';
    public $incrementing = false;

    protected $fillable = [
        'id_work_relation',
        'work_relation',
    ];

    protected $dates = ['deleted_at'];
}
