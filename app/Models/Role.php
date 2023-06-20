<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_roles';

    protected $fillable = [
        'nama_role',
        'work_relation_id'
    ];

    public function AksesForm()
    {
        return $this->hasMany(AksesForm::class, 'role_id', 'id');
    }

    public function WorkRelation()
    {
        return $this->hasOne(WorkRelation::class, 'id_work_relation', 'work_relation_id');
    }

    protected $dates = ['deleted_at'];

}
