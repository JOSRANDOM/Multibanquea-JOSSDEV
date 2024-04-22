<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exam;


class solveExpiredExams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:solve-expired-exams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resolver exámenes expirados';

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
        echo now();
        $exams = Exam::where('score',0)->whereNull('completed_at')->where('expiration_at','<=',now())->orderBy('id','desc')->get();
        // dd($exams);
        foreach ($exams as $key => $exam) {

            $score = (int) round($exam->correct_questions->count() / $exam->questions->count() * 100);
            $exam->score = $score;
            $exam->total_correct_questions = $exam->correct_questions->count();
            $exam->total_incorrect_questions = $exam->incorrect_questions->count();
            $exam->total_questions = $exam->correct_questions->count() +  $exam->incorrect_questions->count();
            $exam->completed_at = now();
            $exam->save();
        }

    }
}
