<?php

namespace App\Models;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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

    public function GenerateBarcode()
    {
        $barcodeRoom = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate(url('') . '/view-room/' . $this->id_site . '/' .  $this->id_room);

        $outputBarcode = '/public/' . $this->id_site . '/img/qr-code/room/' . $this->id_room . '-barcode_room.png';
        $barcode = '/storage/' . $this->id_site . '/img/qr-code/room/' . $this->id_room . '-barcode_room.png';

        Storage::disk('local')->put($outputBarcode, $barcodeRoom);

        $this->barcode_room = $barcode;
        $this->save();
    }

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

    public function InspectionEng()
    {
        return $this->hasMany(EquiqmentEngineeringDetail::class, 'id_room', 'id_room');
    }
}
