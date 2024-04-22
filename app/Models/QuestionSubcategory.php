<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSubcategory extends Model
{
    use HasFactory;

    /**
     * The question category the owns the question subcategory.
     */
    public function question_category()
    {
        return $this->belongsTo(QuestionCategory::class);
    }

    /**
     * The questions that belong to the question subcategory.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
