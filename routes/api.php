<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FormsController;
use App\Http\Controllers\Api\QuestionsController;
use App\Http\Controllers\Api\AnswersController;
use App\Http\Controllers\Api\StylesController;
use App\Http\Controllers\Api\type_answerController;
use App\Http\Controllers\Api\multiple_choicesController;
use App\Http\Controllers\Api\UsersController;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('forms', FormsController::class);
    Route::apiResource('questions', QuestionsController::class)->except('destroy');
    Route::apiResource('styles', StylesController::class);
    Route::apiResource('type_answer', type_answerController::class);
    Route::apiResource('multiple_choices', multiple_choicesController::class);

    Route::get('forms/formsAndAnswers/{idForm}/', [FormsController::class, 'formsAndAnswers']);
    Route::get('answers/{idForm}/', [FormsController::class, 'answersByForm']);
});


//endpoints sem necessidade de autenticação
Route::apiResource('user', UsersController::class)->only('store');
Route::apiResource('answers', AnswersController::class)->except('destroy');


//errro ao tentar acessar sem autenticação
Route::get('error', function () {
    return response()->json('Access denied', 403);
})->name('error');

