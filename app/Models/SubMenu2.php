<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'route_name',
        'parent_id',
    ];

    public function subMenu()
    {
        return $this->hasOne(SubMenu::class, 'id', 'parent_id');
    }
}
