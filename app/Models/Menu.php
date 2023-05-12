<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'route_name',
        'heading_id',
        'icon'
    ];

    public function subMenus()
    {
        return $this->hasMany(SubMenu::class, 'parent_id', 'id');
    }
}
