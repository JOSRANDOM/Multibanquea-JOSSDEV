<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    /**
     * Display the ranking page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());

        $users_by_score = DB::table('exams')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COUNT(exam_question.id) AS questions'),
                DB::raw('SUM(exam_question.correct) AS correct_questions'),
                DB::raw('ROUND(SUM(exam_question.correct) / COUNT(exam_question.correct) * 100, 2) AS score'),
            )
            ->join('users', 'users.id', 'exams.user_id')
            ->join('exam_question', 'exam_question.exam_id', 'exams.id')
            ->whereNotNull('exams.completed_at')
            ->groupBy('users.id')
            ->havingRaw('COUNT(exam_question.id) >= 20')
            ->orderByDesc('score')
            ->orderByDesc('correct_questions')
            ->get();

        return view('ranking.index', [
            'user' => $user,
            'users_by_score' => $users_by_score,
        ]);
    }
}
