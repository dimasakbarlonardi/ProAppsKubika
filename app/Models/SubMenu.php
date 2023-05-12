<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'route_name',
        'parent_id',
    ];

    public function subMenus2()
    {
        return $this->hasMany(SubMenu2::class, 'parent_id', 'id');
    }

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'parent_id');
    }
}
