<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KepemilikanUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_pemilik_d';
    protected $primaryKey = 'id';
    
    protected $fillable = ([
        'id_kepemilikan_unit',
        'id_pemilik',
        'id_unit',
        'id_status_hunian',
        'tgl_mulai',
        'no_bukti_milik',
        'keterangan',
    ]);

    protected $dates = ['deleted_at'];

    public function Pemilik()
    {
        return $this->hasOne(OwnerH::class, 'id_pemilik', 'id_pemilik');
    }

    public function StatusHunianTenant()
    {
        return $this->hasOne(StatusHunianTenant::class, 'id_statushunian_tenant', 'id_status_hunian');
    }

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'id_unit');
    }
}
