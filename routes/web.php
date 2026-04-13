<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\UserSurveyController;

Route::get('/', [UserSurveyController::class, 'index'])->name('home');
Route::get('/survey/{slug}', [UserSurveyController::class, 'show'])->name('survey.show');
Route::post('/survey/{slug}/submit', [UserSurveyController::class, 'submit'])->name('survey.submit');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');
Route::post('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login'); // or admin login page
})->name('admin.logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [SurveyController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('admin.surveys.create');
    Route::post('/surveys/store', [SurveyController::class, 'store'])->name('admin.surveys.store');
    Route::post('/surveys/{id}/toggle', [SurveyController::class, 'toggle'])->name('admin.surveys.toggle');
    Route::get('/surveys/{id}/results', [SurveyController::class, 'results'])->name('admin.surveys.results');
    Route::get('/surveys/{id}/download', [SurveyController::class, 'download'])->name('admin.surveys.download');
});

require __DIR__.'/auth.php';