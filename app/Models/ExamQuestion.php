<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamQuestion extends Model
{
    protected $table = 'exam_question';
    use HasFactory;

    protected $fillable = [
        'note',
        'answered'
    ];

    public function get_note($id)
    {
        return $this->hasOne(ExamQuestion::class)
            ->where('id', $id)
            ->limit(1);
    }

}
