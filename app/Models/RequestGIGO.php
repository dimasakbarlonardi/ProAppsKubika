<?php

namespace App\Models;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class RequestGIGO extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_request_gigo';

    protected $fillable = [
        'no_tiket',
        'no_request_gigo',
        'date_request_gigo',
        'no_pol_pembawa',
        'id_pembawa',
        'gigo_type',
        'nama_pembawa',
        'status_request',
        'barcode',
        'sign_approval_1',
        'sign_approval_2',
        'sign_approval_3',
    ];

    public function GenerateBarcode()
    {
        $barcodeGIGO = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate(url('') . '/api/v1/gigo/done/' . $this->id);

        $outputGIGO = '/public/' . $this->id_site . '/img/qr-code/gigo/' . $this->id . '-barcode_gigo.png';
        $gigo = '/storage/' . $this->id_site . '/img/qr-code/gigo/' . $this->id . '-barcode_gigo.png';

        Storage::disk('local')->put($outputGIGO, $barcodeGIGO);

        $this->barcode = $gigo;
        $this->save();
    }

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_tiket', 'no_tiket');
    }

    public function DetailGIGO()
    {
        return $this->hasMany(DetailGIGO::class, 'id_request_gigo', 'id');
    }
}
