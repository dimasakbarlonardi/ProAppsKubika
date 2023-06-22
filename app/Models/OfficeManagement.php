<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeManagement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_office_management';
    protected $primaryKey = 'id_hk_office';

    protected $fillable = [
        'id_hk_office',
        'nama_hk_office',
        'subject',
        'periode',
    ];
    protected $dates = ['deleted_at'];
}
