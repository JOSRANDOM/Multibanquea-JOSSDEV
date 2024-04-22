<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exam;
use App\Models\ExamQuestion;

class calculeQuestionsInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:calcule-question-information';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener Total de Preguntas y correctas e incorrectas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', -1);
        $exams = Exam::where('total_questions',0)->get();
        // $exams = Exam::where('total_questions',0)->whereNotNull('completed_at')->get();
        // dd($exams);
        foreach ($exams as $key => $exam) {
            if($exam->completed_at){
                $exam->total_correct_questions = $exam->correct_questions()->count();
                $exam->total_incorrect_questions = $exam->incorrect_questions()->count();
            }
            $exam->total_questions = $exam->questions()->count();
            $exam->save();
        }

        return 'Echo';
    }
}
