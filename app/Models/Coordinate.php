<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Coordinate extends Model
{
    use HasFactory;

    protected $table = 'tb_coordinates';

    protected $fillable = [
        'id_site',
        'site_name',
        'latitude',
        'longitude',
        'radius',
        'barcode_image',
    ];

    public function GenerateBarcode()
    {
        $barcodeCoordinate = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate(url('') . '/api/v1/site-location/' . $this->id);

        $outputBarcode = '/public/' . $this->id_site . '/img/qr-code/coordinate/' . $this->id . '-barcode_coordinate.png';
        $barcode = '/storage/' . $this->id_site . '/img/qr-code/coordinate/' . $this->id . '-barcode_coordinate.png';

        Storage::disk('local')->put($outputBarcode, $barcodeCoordinate);

        $this->barcode_image = $barcode;
        $this->save();
    }
}
