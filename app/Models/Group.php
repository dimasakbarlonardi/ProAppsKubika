<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_group';
    public $incrementing = false;

    protected $fillable = [
        'id_pengurus',
        'id_group',
        'nama_group',
        'alamat',
        'kode_pos',
        'no_telp1',
        'no_telp2',
        'email',
        'provinsi',
        'fb',
        'ig'
    ];

    protected $dates = ['deleted_at'];
}
