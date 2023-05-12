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
    ];

    public function AksesForm()
    {
        return $this->hasMany(AksesForm::class, 'role_id', 'id');
    }
}
