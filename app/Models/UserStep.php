<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStep extends Model
{
    use HasFactory;

    protected $table = 'user_steps';

    protected $fillable = [
        'user_id',
        'step_1',
        'step_2',
        'step_3',
        'exams_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];
}
