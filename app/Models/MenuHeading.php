<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHeading extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'heading_id', 'id');
    }
}
