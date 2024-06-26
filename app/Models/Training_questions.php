<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training_questions extends Model
{
    use HasFactory;
    public $table = "training_questions";

    // Agrega los campos que pueden ser asignados masivamente
    protected $fillable = [
        'user_id', 
        'questions_id', 
        'answers_id',
        'is_correct',
        'date',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];
}
