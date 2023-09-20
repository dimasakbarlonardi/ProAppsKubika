<?php

namespace App\Models;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Package extends Model
{
    use HasFactory;

    protected $table = 'tb_package';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'package_receipt_number',
        'receiver_id',
        'unit_id',
        'received_location',
        'courier_type',
        'courier_name',
        'barcode_package',
        'image',
        'receive_time',
        'status',
        'description',
        
    ];

    public function GenerateBarcode()
    {
        $barcodePackage = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate(url('') . '/api/v1/pickup/package/');

        $outputPackage = '/public/' . $this->id_site . '/img/qr-code/package/' . $this->package_receipt_number . '-barcode_package.png';
        $package = '/storage/' . $this->id_site . '/img/qr-code/package/' . $this->package_receipt_number . '-barcode_package.png';

        Storage::disk('local')->put($outputPackage, $barcodePackage);

        $this->barcode_package = $package;
        $this->save();
    }

    public function Unit()
    {
        return $this->hasOne(Unit::class, 'id_unit', 'unit_id');
    }

    public function Receiver()
    {
        return $this->hasOne(User::class, 'id_user', 'receiver_id');
    }
}
