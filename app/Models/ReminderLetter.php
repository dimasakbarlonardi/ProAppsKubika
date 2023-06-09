<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReminderLetter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_reminder_letter';
    protected $primaryKey = 'id_reminder_letter';

    protected $fillable = [
        'id_reminder_letter',
        'reminder_letter',
        'durasi_reminder_letter',
    ];

    protected $dates = ['deleted_at'];
}
