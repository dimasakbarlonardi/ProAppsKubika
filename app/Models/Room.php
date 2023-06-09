<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_room';
    protected $primaryKey = 'id_room';

    protected $fillable = [
        'id_room',
        'id_site',
        'id_tower',
        'id_lantai',
        'barcode_room',
        'nama_room',
    ];

    protected $dates = ['deleted_at'];

    public function tower()
    {
        return $this->hasOne(Tower::class, 'id_tower', 'id_tower');
    }

    public function floor()
    {
        return $this->hasOne(Floor::class, 'id_lantai', 'id_lantai');
    }

    public function site()
    {
        return $this->hasOne(Site::class, 'id_site', 'id_site');
    }
}
