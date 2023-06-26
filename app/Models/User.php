<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    public $incrementing = false;

    protected $fillable = [
        'id_user',
        'id_site',
        'login_user',
        'nama_user',
        'user_category',
        'password_user',
        'id_status_user',
        'id_role_hdr'
    ];

    public function RoleH()
    {
       return $this->hasOne(Role::class, 'id', 'id_role_hdr');
    }

    public function Karyawan()
    {
        return $this->hasOne(Karyawan::class, 'email_karyawan', 'login_user');
    }

    public function Tenant()
    {
        return $this->hasOne(Tenant::class, 'email_tenant', 'login_user');
    }
}
