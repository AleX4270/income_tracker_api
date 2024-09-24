<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\IncomeController;
use App\Http\Middleware\LanguageMiddleware;

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/email/verify/{id}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    Route::get('/email/resend', [AuthController::class, 'resendEmail'])->name('verification.resend');
    Route::get('/password/request-reset', [AuthController::class, 'requestPasswordReset'])->name('password.reset');
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);
});

Route::middleware([LanguageMiddleware::class, 'auth:sanctum'])->group(function() {
    Route::prefix('income')->group(function() {
        Route::get('', [IncomeController::class, 'index']);
        Route::post('/form', [IncomeController::class, 'form']);
        Route::put('/form', [IncomeController::class, 'form']);
        Route::delete('', [IncomeController::class, 'delete']);
    });

    Route::prefix('currency')->group(function() {
        Route::get('', [CurrencyController::class, 'index']);
        Route::post('/form', [CurrencyController::class, 'form']);
        Route::put('/form', [CurrencyController::class, 'form']);
        Route::delete('', [CurrencyController::class, 'delete']);
    });

    Route::prefix('incomeCategory')->group(function() {
        Route::get('', [IncomeCategoryController::class, 'index']);
        Route::post('/form', [IncomeCategoryController::class, 'form']);
        Route::put('/form', [IncomeCategoryController::class, 'form']);
        Route::delete('', [IncomeCategoryController::class, 'delete']);
    });
});