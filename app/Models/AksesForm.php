<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesForm extends Model
{
    use HasFactory;

    protected $table = 'tb_akses_form';

    protected $fillable = [
        'kode_form',
        'route_name',
        'nama_form',
        'type_form',
        'status_form',
        'id_roles_d',
        'role_id',
        'menu_id',
        'heading',
        'menu_category',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'id', 'menu_id');
    }

    public $timestamps = false;
}
