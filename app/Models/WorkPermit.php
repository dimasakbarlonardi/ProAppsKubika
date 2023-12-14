<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WorkPermit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_work_permit';
    protected $fillable = [
        'no_tiket',
        'no_request_permit',
        'no_work_permit',
        'nama_project',
        'id_bayarnon',
        'jumlah_supervisi',
        'jumlah_deposit',
        'status_request',
        'id_user_work_permit',
        'id_work_relation',
        'is_worked',
        'is_done',
        'sign_approval_1',
        'sign_approval_2',
        'sign_approval_3',
        'sign_approval_4',
        'sign_approval_5',
        'no_cash_receipt',
        'status_bayar',
        'barcode'
    ];

    public function GenerateBarcode()
    {
        $barcodeWP = QrCode::format('png')
            ->merge(public_path('assets/img/logos/proapps.png'), 0.6, true)
            ->size(500)
            ->color(0, 0, 0)
            ->eyeColor(0, 39, 178, 155, 0, 0, 0)
            ->eyeColor(1, 39, 178, 155, 0, 0, 0)
            ->eyeColor(2, 39, 178, 155, 0, 0, 0)
            ->errorCorrection('H')
            ->generate(url('') . '/work-permit/letter/' . $this->id . '/' . $this->Ticket->id_site);

        $outputWP = '/public/' . $this->id_site . '/img/qr-code/work-permit/' . $this->id . '-barcode_wp.png';
        $barcode = '/storage/' . $this->id_site . '/img/qr-code/work-permit/' . $this->id . '-barcode_wp.png';

        Storage::disk('local')->put($outputWP, $barcodeWP);

        $this->barcode = $barcode;
        $this->save();
    }

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_tiket', 'no_tiket');
    }

    public function RequestPermit()
    {
        return $this->hasOne(RequestPermit::class, 'no_request_permit', 'no_request_permit');
    }

    public function WorkRelation()
    {
        return $this->hasOne(WorkRelation::class, 'id_work_relation', 'id_work_relation');
    }

    public function CashReceipt()
    {
        return $this->hasOne(CashReceipt::class, 'no_reff', 'no_work_permit');
    }

    public function BAPP()
    {
        return $this->hasOne(BAPP::class, 'no_request_permit', 'no_request_permit');
    }

    protected $dates = ['deleted_at'];
}
