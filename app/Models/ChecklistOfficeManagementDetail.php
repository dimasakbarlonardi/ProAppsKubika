<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistOfficeManagementDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_office_management_d';
    protected $primaryKey = 'id_eng_office_management';

    protected $fillable = [
        'id_eng_office_management',
        'no_checklist_office_management',
        'check_point',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
