<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncidentalReportEng extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tb_incidental_eng';

    protected $primaryKey = 'id';

    protected $fillable = [
      'id',
      'reported_name',
      'incident_name',
      'id_room',
      'date',
      'time',
      'image',
      'keterangan',
    ];

    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

}
