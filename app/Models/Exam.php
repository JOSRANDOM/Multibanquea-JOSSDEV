<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_exam_id',
        'question_category_id',
        'user_id',
        'public_id',
        'simulacrum',
        'type',
        'sharing_token',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'expiration_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'completed_at' => 'datetime',
        'expiration_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'public_id';
    }

    /**
     * The parent exam that owns the exam.
     */
    public function parent_exam()
    {
        return $this->belongsTo(Exam::class, 'parent_exam_id');
    }

    /**
     * The question category that belong to the exam.
     */
    public function question_category()
    {
        return $this->belongsTo(QuestionCategory::class);
    }

    /**
     * The questions that belong to the exam.
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot("answer_id", "correct", "id", "answered");
    }

    /**
     * The answered questions that belong to the exam.
     */
    public function answered_questions()
    {
        return $this->belongsToMany(Question::class)->wherePivot("answer_id", "!=", "null");
    }

    /**
     * The unanswered questions that belong to the exam.
     */
    public function unanswered_questions()
    {
        return $this->belongsToMany(Question::class)->wherePivot("answer_id", null)->withPivot("id");
    }

    /**
     * The correctly answered questions that belong to the exam.
     */
    public function correct_questions()
    {
        return $this->belongsToMany(Question::class)->wherePivot("correct", 1);
    }

    /**
     * The incorrectly answered questions that belong to the exam.
     */
    public function incorrect_questions()
    {
        return $this->belongsToMany(Question::class)->wherePivot("correct", 0);
    }

    /**
     * The user that owns the exam.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Whether the exam is completed.
     *
     * @return boolean
     */
    public function isCompleted()
    {
        return !is_null($this->completed_at);
    }

    /**
     * Get the exam progress.
     *
     * @return float
     */
    public function getProgress()
    {
        // Verifica si hay preguntas disponibles para contar
        if ($this->questions->count() > 0) {
            return round($this->answered_questions->count() / $this->questions->count() * 100);
        } else {
            return 0; // O cualquier valor predeterminado que consideres adecuado cuando no hay preguntas
        }
    }
    

    public function getProgressNumber()
    {
        return $this->answered_questions->count();
    }
    /**
     * Get the next unanswered questions that belong to the exam.
     */
    public function getNextUnansweredQuestion()
    {
        return $this->unanswered_questions()->first();
    }
    /**
     * The question category that belong to the exam.
     */
    public function simulacrum_data()
    {
        return $this->belongsTo(Simulacrum::class, 'simulacrum', 'slug');
    }
    public function extraordinary_data()
    {
        return $this->belongsTo(Extraordinary::class, 'simulacrum', 'slug');
    }
}
