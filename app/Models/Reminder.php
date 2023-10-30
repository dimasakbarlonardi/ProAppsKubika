<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_reminders';

    protected $fillable = [
        'reminder_name',
        'reminder_date',
        'remind_before',
        'work_relation_id'
    ];

    public function WorkRelation()
    {
        return $this->hasOne(WorkRelation::class, 'id_work_relation', 'work_relation_id');
    }
}
