<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class EquiqmentEngineeringDetail extends Model
    {
        use HasFactory;

        protected $table = 'tb_equiqment_engineering_detail';

        protected $primaryKey = 'id_equiqment_engineering_detail';

        protected $fillable = [
            'id_equiqment_engineering_detail',
            'id_equiqment_engineering',
            'image',
            'id_room',
            'status',
            'id_equiqment',
            'status',
            'checklist_datetime',
            'schedule',
            'status_schedule',
            'user_id',
        ];

        protected $dates = ['deleted_at'];

        public function equipment()
        {
            return $this->hasOne(EquiqmentAhu::class, 'id_equiqment_engineering', 'id_equiqment_engineering');
        }

        public function Room()
        {
            return $this->hasOne(Room::class, 'id_room', 'id_room');
        }

        public function Schedule()
        {
            return $this->hasOne(EquiqmentAhu::class, 'id_equiqment_engineering', 'id_equiqment_engineering');
        }

        public function CheckedBy()
        {
            return $this->hasOne(User::class, 'id_user', 'user_id');
        }
    }
