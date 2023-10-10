<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileMenu extends Model
{
    use HasFactory;

    protected $table = 'tb_mobile_menu';

    protected $fillable = [
        'kode_menu',
        'nama_menu',
    ];

    public function getRoleMenus()
    {
        return $this->hasMany(AccessMobileMenu::class, 'menu_id', 'id');
    }
}
