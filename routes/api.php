<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StatisticsBI;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        /**
         * Exams
         */
        Route::get('/exam/{exam}/{question}/answers', [QuestionController::class, 'apiGetAnswers']);
        Route::get('/exam/{exam}/{question}/{answer}', [QuestionController::class, 'apiAnswer']);
    });

    /**
     * Subscriptions
     */
    Route::post('/subscriptions/ipn', [SubscriptionController::class, 'apiIpn'])->name('api.subscriptions.ipn');
});

//API`s REPORTES BI CIENTIFICA
//SIN PARAMETROS
//Route::get('/statistics/RPT_CIENTIFICA01', [StatisticsBI::class, 'RPT_CIENTIFICA01']);
//CON PARAMETROS - 
Route::get('/statistics/RPT_CIENTIFICA02', [StatisticsBI::class, 'RPT_CIENTIFICA02']);