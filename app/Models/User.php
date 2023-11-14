<?php

namespace App\Models;

use App\Helpers\ConnectionDB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    public $incrementing = false;

    protected $hidden = ['password_user'];

    protected $fillable = [
        'id_user',
        'id_site',
        'login_user',
        'nama_user',
        'user_category',
        'password_user',
        'id_status_user',
        'id_role_hdr',
        'profile_picture',
        'fcm_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

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

    public function TenantUnit()
    {
        return $this->hasOne(TenantUnit::class, 'id_tenant', 'id_user');
    }

    public function Owner()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function tools()
    {
        return $this->belongsTo(ToolsEngineering::class, 'id');
    }

    public function Attendance($date = "2023-09-01")
    {
        return $this->hasOne(Attendance::class, 'id_user', 'id_user')
            ->where('date_schedule', $date);
    }

    public function RoomChat($idUser)
    {
        $connChat = ConnectionDB::setConnection(new Chat());

        $chats = $connChat->orWhere('sender_id', $idUser)
            ->orWhere('receiver_id', $idUser)
            ->orderBy('id', 'DESC')
            ->first();

        return $chats;
    }

    public function Chats()
    {
        return $this->hasMany(Chat::class, 'sender_id', 'id_user');
    }
}
