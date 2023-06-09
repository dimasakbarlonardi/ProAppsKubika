<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngPompasumpit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_pompasumpit';
    protected $primaryKey = 'id_eng_pompasumpit';

    protected $fillable = [
        'id_eng_pompasumpit',
        'nama_eng_pompasumpit',
        'subject',
        'dsg',
    ];
    protected $dates = ['deleted_at'];
}
