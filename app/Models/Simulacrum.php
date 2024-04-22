<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulacrum extends Model
{
    use HasFactory;
    public $table = "simulacrums";

    public function exams()
    {
        return $this->belongsTo(Exam::class,'slug','simulacrum');
    }
    public function countExamsUSer($user_id,$slug)
    {
        $exams_simulacrum = Exam::where('user_id',$user_id)->where('simulacrum',$slug)->count();
        return $exams_simulacrum;
    }
    public function examsUSer($user_id,$slug)
    {
        $exams_simulacrum = Exam::select('public_id')->where('user_id',$user_id)->where('simulacrum',$slug)->first();
        return $exams_simulacrum;
    }
}
