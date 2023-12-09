<?php

namespace App\Models;

use Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class EquiqmentAhu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_equiqment_ahu';
    protected $primaryKey = 'id_equiqment_engineering';

    protected $fillable = [
        'id_equiqment_engineering',
        'id_equiqment',
        'barcode_room',
        'no_equiqment',
        'equiqment',
        'id_role',
        'id_room',
    ];

    protected $dates = ['deleted_at'];

    public function GenerateBarcode($data)
    {
        $barcodeRoom = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate($data);

        $outputBarcode = '/public/' . Auth::user()->id_site . '/img/qr-code/equipment-eng/' . $this->id_equiqment_engineering . '-barcode_equipment_engineering.png';
        $barcode = '/storage/' . Auth::user()->id_site . '/img/qr-code/equipment-eng/' . $this->id_equiqment_engineering . '-barcode_equipment_engineering.png';

        Storage::disk('local')->put($outputBarcode, $barcodeRoom);

        $this->barcode_room = $barcode;
        $this->save();
    }

    public function equiqment()
    {
        return $this->hasOne(ChecklistAhuH::class, 'id_equiqment_ahu', 'id_equiqment_ahu');
    }

    public function Room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function Floor()
    {
        return $this->hasOne(Floor::class, 'id_lantai', 'id_room');
    }

    public function Schedule()
    {
        return $this->hasOne(EquiqmentEngineeringDetail::class, 'id_equiqment_engineering', 'id_equiqment_engineering');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }

    public function InspectionEng()
    {
        return $this->hasMany(ChecklistParameterEquiqment::class, 'id_item', 'id_equiqment_engineering')
            ->where('id_equiqment', 2);
    }
}
