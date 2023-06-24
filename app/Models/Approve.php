<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    use HasFactory;

    protected $table = 'tb_approve';
    protected $primaryKey = 'id_approval_subject';

    protected $fillable = [
        'subject_name',
        'approval_1',
        'approval_2',
        'approval_3',
        'approval_4',
        'approval_5',
        'approval_6',
    ];
}
