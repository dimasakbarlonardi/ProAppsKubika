<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquiqmentChiller extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_equiqment_chiller';
    protected $primaryKey = 'id_equiqment_chiller';

    protected $fillable =[
        'id_equiqment_chiller',
        'no_equiqment',
        'equiqment',    
        'id_role',
        'id_room',
        'januari',
        'febuari',
        'maret',
        'april',
        'mei',
        'juni',
        'juli',
        'agustus',
        'september',
        'oktober',
        'november',
        'december'

    ];

    protected $dates = ['deleted_at'];

    public function equiqment()
    {
        return $this->hasOne(ChecklistAhuH::class, 'id_equiqment_chiller', 'id_equiqment_chiller');
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