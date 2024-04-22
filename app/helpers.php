<?php

if (!function_exists('getTimeExam')) {
    function getTimeExam($quantity)
    {
        $time = 0;
        switch ($quantity) {
            case 10:
                $time = env('TIME_EXAM_10_QUESTIONS');
                break;
            case 25:
                $time = env('TIME_EXAM_25_QUESTIONS');
                break;
            case 50:
                $time = env('TIME_EXAM_50_QUESTIONS');
                break;
            case 51:
                $time = env('TIME_EXAM_51_QUESTIONS');
                break;
            case 90:
                $time = env('TIME_EXAM_90_QUESTIONS');
                break;
            case 100:
                $time = env('TIME_EXAM_100_QUESTIONS');
                break;
            case 120:
                $time = env('TIME_EXAM_180_QUESTIONS');
                break;
            case 200:
                $time = env('TIME_EXAM_200_QUESTIONS');
                break;
            default:
                $time = 120;
                break;
        }
        return $time;
    }
}

if (!function_exists('isTimeExpired')) {
    function isTimeExpired($expiration_time): bool
    {
        $is_exam_expired = false;
        if ($expiration_time != '') {
            if (new DateTime() > new DateTime($expiration_time)) {
                $is_exam_expired = true;
            }
        }
        return $is_exam_expired;
    }
}

if (!function_exists('setExpirationTime')) {
    function setExpirationTime($exam, $time)
    {
        $exam->expiration_at = now()->addMinutes($time);
        $exam->save();
        session()->put('exam_expiration_time', $exam->expiration_at);
    }
}
