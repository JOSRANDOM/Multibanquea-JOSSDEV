<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    use HasFactory;

    /**
     * The question subcategories that belong to the question category.
     */
    public function question_subcategories()
    {
        return $this->hasMany(QuestionSubcategory::class);
    }

    /**
     * The questions that belong to the question category.
     */
    public function questions()
    {
        return $this->hasManyThrough(Question::class, QuestionSubcategory::class);
    }
}
