<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Answer;
use Illuminate\Http\Request;

class ReevaluateExamController extends Controller
{
    //
    public function upgrade($slug)
    {
        $exams = Exam::where('type','SIMULACRUM')->where('simulacrum',$slug)->get();
        if($exams->count()){
            echo $exams->count();
            foreach ($exams as $key => $exam) {
                $examQuestions = ExamQuestion::where('exam_id',$exam->id)->get();
                echo 'exam =>' . $exam->public_id .'<br>';
                foreach ($examQuestions as $key => $question) {
                    //VERIFICAR SI ES CORRECTO

                    $answer_correct = Answer::where('question_id',$question->question_id)->where('correct',1)->first();
                    if($question->answer_id == $answer_correct->id){
                        $question->correct = 1;
                    }else{
                        $question->correct = 0;
                    }
                    $question->save();
                    echo $question->answer_id . ' correct '. $question->correct. '   '.$answer_correct->id.  ($question->answer_id == $answer_correct->id ? 'CORRECTO' : '-' ) .'<br>';

                    // dd($question,$answer_correct->id);
                    //  question_id
                }
                // dd('FIN');
                // $question_belongs_to_exam = $exam->questions->contains($question);
                // $answer_belongs_to_question = $exam->questions->contains($question);
                $score = (int) round($exam->correct_questions->count() / $exam->questions->count() * 100);

                $exam->total_correct_questions = $exam->correct_questions->count();
                $exam->total_questions = $exam->questions->count();
                $exam->total_incorrect_questions = $exam->incorrect_questions->count();
                // $exam->completed_at = now();
                $exam->score = $score;
                $exam->save();
                // dd($exam->score,$score);
            }

        }else{
            echo 'NO SE ENCONTRO EXAMS';
        }

    }
}
