<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Request;

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
        'isempty',
    ];

    protected $dates = ['deleted_at'];

    public function GenerateBarcode()
    {
        $barcodeListrik = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate(url('') . '/api/v1/insert-electric/' . $this->id_unit);

        $barcodeAir = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate(url('') . '/api/v1/insert-water/' . $this->id_unit);

        $outputListrik = '/public/' . $this->id_site . '/img/qr-core/meter-listrik/' . $this->id_unit . '-barcode_meter_listrik.png';
        $listrik = '/storage/' . $this->id_site . '/img/qr-core/meter-listrik/' . $this->id_unit . '-barcode_meter_listrik.png';

        $outputAir = '/public/' . $this->id_site . '/img/qr-core/meter-air/' . $this->id_unit . '-barcode_meter_air.png';
        $air = '/storage/' . $this->id_site . '/img/qr-core/meter-air/' . $this->id_unit . '-barcode_meter_air.png';

        Storage::disk('local')->put($outputListrik, $barcodeListrik);
        Storage::disk('local')->put($outputAir, $barcodeAir);

        $this->barcode_meter_listrik = $listrik;
        $this->barcode_meter_air = $air;
        $this->save();
    }

    public function site()
    {
        return $this->hasOne(Site::class, 'id_site', 'id_site');
    }

    public function hunian()
    {
        return $this->hasOne(Hunian::class, 'id_hunian', 'id_hunian');
    }

    public function tower()
    {
        return $this->hasOne(Tower::class, 'id_tower', 'id_tower');
    }

    public function floor()
    {
        return $this->hasOne(Floor::class, 'id_lantai', 'id_lantai');
    }

    public function TenantUnit()
    {
        return $this->hasOne(TenantUnit::class, 'id_unit', 'id_unit');
    }

    public function electricUUS()
    {
        return $this->hasMany(ElectricUUS::class, 'id_unit', 'id_unit')->latest();
    }

    public function allElectricUUS()
    {
        return $this->hasMany(ElectricUUS::class, 'id_unit', 'id_unit');
    }

    public function allElectricUUSbyYear()
    {
        return $this->hasMany(ElectricUUS::class, 'id_unit', 'id_unit')->where('periode_tahun', Carbon::now()->format('Y'));
    }

    public function waterUUS()
    {
        return $this->hasMany(WaterUUS::class, 'id_unit', 'id_unit')->latest();
    }

    public function allWaterUUS()
    {
        return $this->hasMany(WaterUUS::class, 'id_unit', 'id_unit');
    }

    public function allWaterUUSbyYear()
    {
        return $this->hasMany(WaterUUS::class, 'id_unit', 'id_unit')->where('periode_tahun', Carbon::now()->format('Y'));
    }
}
