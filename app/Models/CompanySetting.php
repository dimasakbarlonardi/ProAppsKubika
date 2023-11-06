<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $table = 'tb_company_settings';

    protected $fillable = [
        'company_name',
        'company_logo',
        'company_address',
    ];
}
