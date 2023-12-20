<?php

namespace App\Models;

use App\Helpers\CryptoHelper;
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

    public function GenerateBarcode()
    {
        $checklists = [];

        foreach ($this->InspectionEng as $data) {
            $checklists[]['question'] = $data->ChecklistEng->nama_eng_ahu;
        }

        $data = [
            "id_equipment_engineering" => $this->id_equiqment_engineering,
            "equipment" => $this->equiqment,
            "status_schedule" => "Not Done",
            "id_room" => $this->id_room,
            "room" => $this->Room->nama_room,
            "Tower" => $this->Room->Tower->nama_tower,
            "Floor" => $this->Room->Floor->nama_lantai,
            "checklists" => $checklists
        ];

        $json = json_encode($data);

        $mykey = '@Pr04pp5';
        $myiv = base64_encode($mykey);

        $key = substr(hash('sha256', $mykey), 0, 32);
        $iv = substr(hash('sha256', $myiv), 0, 16);

        $cipherText = openssl_encrypt($json, 'aes-256-cbc', $key, 0, $iv);
        $encrypted = encryptURL($cipherText);
        $barcode = 'https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data=' . $encrypted;

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
