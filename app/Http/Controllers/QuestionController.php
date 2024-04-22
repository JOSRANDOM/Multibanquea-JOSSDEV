<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Notifications\QuestionReported;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Answers a question.
     *
     * @param  \App\Models\Exam  $exam
     * @param  \App\Models\Question  $question
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function apiAnswer(Exam $exam, Question $question, Answer $answer)
    {
        $exam_belongs_to_user = Auth::id() == $exam->user->id;
        $question_belongs_to_exam = $exam->questions->contains($question);
        $answer_belongs_to_question = $exam->questions->contains($question);

        if (!$exam_belongs_to_user || !$question_belongs_to_exam || !$answer_belongs_to_question) {
            abort(401);
        }

        $correct_answer = $question->getCorrectAnswer();
        $user_answered_correctly = $correct_answer->id === $answer->id;

        $exam_question = $exam->questions->find($question)->pivot;
        $exam_question->answer_id = $answer->id;
        $exam_question->correct = $user_answered_correctly;
        $exam_question->save();

        return response("Answered", 200);
    }

    /**
     * Returns the question's answers.
     *
     * @param  \App\Models\Exam  $exam
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function apiGetAnswers(Exam $exam, Question $question)
    {
        $exam_belongs_to_user = Auth::id() == $exam->user->id;
        $question_belongs_to_exam = $exam->questions->contains($question);

        if (!$exam_belongs_to_user || !$question_belongs_to_exam) {
            abort(401);
        }

        return response()->json($question->answers->map(function ($answer) {
            return $answer->only(['id', 'text']);
        })->shuffle());
    }

    /**
     * Report a question.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request, Question $question)
    {
        $validated = $request->validate([
            'user_message' => 'max:5000',
        ]);

        $user_message = $validated['user_message'];

        $user = Auth::user();

        $user->notify(new QuestionReported($question, $user, $user_message));

        /**
         * Return the user to the last view.
         */

        return redirect()->back()->with('success', '¡Gracias por reportar un problema con esta pregunta! Revisaremos tu reporte a la brevedad posible.');
    }
}
