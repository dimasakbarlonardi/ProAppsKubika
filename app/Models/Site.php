<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Site extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $primaryKey = 'id_site';
    public $incrementing =  false;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'db_name' => [
                'source' => 'nama_site'
            ]
        ];
    }

    protected $fillable = [
        'id_site',
        'id_pengurus',
        'nama_site',
        'alamat',
        'kode_pos',
        'no_telp1',
        'no_telp2',
        'email',
        'provinsi',
        'fb',
        'ig',
        'db_name'
    ];

    protected $dates = ['deleted_at'];

    public function pengurus()
    {
        return $this->hasOne(Pengurus::class, 'id_pengurus', 'id_pengurus');
    }

}
