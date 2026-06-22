<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;

// Главная страница (управление вкладками идет через ?tab= в URL)
Route::get('/', [SurveyController::class, 'index'])->name('survey.index');

// Обработчики кнопок и форм через классический POST метод
Route::post('/update-title', [SurveyController::class, 'updateTitle'])->name('survey.update_title');
Route::post('/add-question', [SurveyController::class, 'addQuestion'])->name('survey.add_question');
Route::post('/delete-question/{id}', [SurveyController::class, 'deleteQuestion'])->name('survey.delete_question');
Route::post('/start-test', [SurveyController::class, 'startSession'])->name('survey.start_session');
Route::post('/save-answers', [SurveyController::class, 'saveAnswers'])->name('survey.save_answers');
