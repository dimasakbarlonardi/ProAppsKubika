<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_package';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'no_resi',
        'status',
        'id_unit',
        'location',
        'courier_type',
        'courier_name',
        'date',
        'time',
        'image',
        'keterangan'

    ];

    protected $dates = ['deleted_at'];

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }
}
