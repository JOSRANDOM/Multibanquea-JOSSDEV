<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * The answers that belong to the question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The exams that have the question.
     */
    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    /**
     * The question subcategory that owns the question.
     */
    public function question_subcategory()
    {
        return $this->belongsTo(QuestionSubcategory::class);
    }

    /**
     * Get the correct answers.
     */
    public function getCorrectAnswer()
    {
        return $this->answers->where("correct", 1)->first();
    }

    /**
     * Get the question category.
     * 
     * @return App\Models\QuestionCategory
     */
    public function getQuestionCategory() {
        return $this->question_subcategory->question_category();
    }
}
