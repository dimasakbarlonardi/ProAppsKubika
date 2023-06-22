<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinReminderLetter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_fin_monthly_reminder_letter';

    protected $primaryKey = 'id_fin_reminder_letter';

    protected $fillable = [
        'id_fin_reminder_letter',
        'no_monthly_invoice',
        'no_reminder_letter',
        'tgl_reminder_letter'
    ];

    protected $dates = ['deleted_at'];
}
