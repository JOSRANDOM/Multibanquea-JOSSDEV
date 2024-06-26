<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    public $table = "training";

        // Agrega los campos que pueden ser asignados masivamente
        protected $fillable = [
            'user_id', 
            'date_training', 
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'id_category'
        ];
}
