<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tower extends Model
{
    use HasFactory, SoftDeletes;

    protected $pimaryKey = 'id_tower';
    public $incrementing = false;
    protected $table = 'tb_tower';


    protected $fillable = [
        'id_tower',
        'id_site',
        'nama_tower',
        'jumlah_lantai',
        'jumlah_unit',
        'keterangan',
    ];

    protected $dates = ['deleted_at'];

    public function site()
    {
        return $this->hasOne(Site::class, 'id_site', 'id_site');
    }

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_tower', 'id_tower');
    }
}
