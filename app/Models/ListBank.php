<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListBank extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tb_list_bank';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name_bank',
        'value',
        'image'
    ];

    protected $dates = ['deleted_at'];
}
