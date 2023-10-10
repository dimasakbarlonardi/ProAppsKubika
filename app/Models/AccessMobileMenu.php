<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessMobileMenu extends Model
{
    use HasFactory;

    protected $table = 'tb_akses_mobile_menu';

    protected $fillable = [
        'kode_menu',
        'role_id',
        'menu_id',
        'menu_category',
    ];

    public $timestamps = false;

    public function Menu()
    {
        return $this->hasOne(MobileMenu::class, 'id', 'menu_id');
    }
}
