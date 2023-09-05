<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncidentalReportHK extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tb_incidental_hk';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'reported_name',
        'incident_name',
        'id_room',
        'date',
        'time',
        'keterangan',
        'image'
    ];

    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }
}
