<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistSecurity extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tb_checklist_security';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'guard',
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'keterangan',
        'image'
    ];

    protected $dates = ['deleted_at'];
    
    public function room()
    {
        return $this->hasOne(Room::class, 'id_room' , 'id_room');
    }

    // public function floor()
    // {
    //     return $this->hasOne(Floor::class, 'id_lantai', 'id_lantai');
    // }
}
