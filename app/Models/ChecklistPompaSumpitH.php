<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistPompaSumpitH extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_pompasumpit_h';
    protected $primaryKey = 'id_eng_checklist_pompasumpit';

    protected $fillable = [
        'id_eng_checklist_pompasumpit',
        'barcode_room',
        'id_room',
        'tgl_checklist',
        'time_checklist',
        'id_user',
        'no_checklist_pompa_sumpit',
    ];
    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }
}
