<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id_unit';
    public $incrementing = false;
    protected $table = 'tb_unit';


    protected $fillable = [
        'id_unit',
        'id_site',
        'id_tower',
        'id_lantai',
        'id_hunian',
        'barcode_unit',
        'nama_unit',
        'luas_unit',
        'barcode_meter_air',
        'barcode_meter_listrik',
        'barcode_meter_gas',
        'no_meter_air',
        'no_meter_listrik',
        'no_meter_gas',
        'meter_air_awal',
        'meter_air_akhir',
        'meter_listrik_awal',
        'meter_listrik_akhir',
        'meter_gas_awal',
        'meter_gas_akhir',
        'keterangan',
    ];

    protected $dates = ['deleted_at'];

    public function site()
    {
        return $this->hasOne(Site::class, 'id_site', 'id_site');
    }

    public function hunian()
    {
        return $this->hasOne(Hunian::class, 'id_hunian', 'id_hunian');
    }
}
