<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusHunianTenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_statushunian_tenant';
    protected $primaryKey = 'id_statushunian_tenant';
    

    protected $fillable =[
        'id_statushunian_tenant',
        'status_hunian_tenant'
    ];
    
    // protected $dates = ['deleted_at'];
}
