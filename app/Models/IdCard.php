<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_id_card';
    protected $primaryKey = 'id_card_type';
    public $incrementing = false;

    protected $fillable = [
        'id_card_type',
        'card_id_name',
    ];

    protected $dates = ['deleted_at'];

}
