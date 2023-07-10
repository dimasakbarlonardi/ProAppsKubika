<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'nama_pembawa',
        'status_request',
        'sign_approval_1',
        'sign_approval_2',
        'sign_approval_3',
    ];

    public function Ticket()
    {
        return $this->hasOne(OpenTicket::class, 'no_tiket', 'no_tiket');
    }

    public function DetailGIGO()
    {
        return $this->hasMany(DetailGIGO::class, 'id_request_gigo', 'id');
    }
}
