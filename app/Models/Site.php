<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Site extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $primaryKey = 'id_site';
    public $incrementing =  false;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'db_name' => [
                'source' => 'nama_site'
            ]
        ];
    }

    protected $fillable = [
        'id_site',
        'id_pengurus',
        'nama_site',
        'alamat',
        'kode_pos',
        'no_telp1',
        'no_telp2',
        'email',
        'provinsi',
        'fb',
        'ig',
        'db_name'
    ];

    protected $dates = ['deleted_at'];

    public function GenerateBarcode()
    {
        $barcodeAttendance = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate(url('') . '/api/v1/attendance/checkin/');

        $outputAttendace = '/public/' . $this->id_site . '/img/qr-code/attendance/' . $this->id_site . '-barcode_attendance.png';
        $attendace = '/storage/' . $this->id_site . '/img/qr-code/attendance/' . $this->id_site . '-barcode_attendance.png';

        Storage::disk('local')->put($outputAttendace, $barcodeAttendance);

        $this->barcode_attendance = $attendace;
        $this->save();
    }

    public function pengurus()
    {
        return $this->hasOne(Pengurus::class, 'id_pengurus', 'id_pengurus');
    }

}
