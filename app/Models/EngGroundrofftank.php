<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngGroundrofftank extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_groundrofftank';
    protected $primaryKey = 'id_eng_groundrofftank';

    protected $fillable = [
        'id_eng_groundrofftank',
        'nama_eng_groundrofftank',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
