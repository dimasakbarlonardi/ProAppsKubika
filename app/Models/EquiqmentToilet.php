<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquiqmentToilet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_equiqment_toilet';
    protected $primaryKey = 'id_equiqment_toilet';

    protected $fillable =[
        'id_equiqment_toilet',
        'no_equiqment',
        'equiqment',    
        'id_role',
        'id_room',
        'senin',
        'selasa',
        'rabu',
        'kamis',
        'jumat',
        'sabtu',
        'minggu'

    ];

    protected $dates = ['deleted_at'];

    public function equiqment()
    {
        return $this->hasOne(ChecklistToiletH::class, 'id_equiqment_toilet', 'id_equiqment_toilet');
    }

    public function room()
    {
        return $this->hasOne(Room::class, 'id_room', 'id_room');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }
}
