<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistTanggaDaruratDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_eng_checklist_tangga_darurat_d';
    protected $primaryKey = 'id_eng_tangga_darurat';

    protected $fillable = [
        'id_eng_tangga_darurat',
        'no_checklist_tangga_darurat',
        'check_point',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];
}
