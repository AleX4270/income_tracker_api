<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\IncomeController;
use App\Models\IncomeCategory;

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/email/verify/{id}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    Route::get('/email/resend', [AuthController::class, 'resendEmail'])->name('verification.resend');

    Route::get('/password/request-reset', [AuthController::class, 'requestPasswordReset'])->name('password.reset');
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);
});

Route::prefix('income')->group(function() {
    Route::get('', [IncomeController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/form', [IncomeController::class, 'form'])->middleware('auth:sanctum');
    Route::put('/form', [IncomeController::class, 'form'])->middleware('auth:sanctum');
    Route::delete('', [IncomeController::class, 'delete'])->middleware('auth:sanctum');
});

Route::prefix('currency')->group(function() {
    Route::get('', [CurrencyController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/form', [CurrencyController::class, 'form'])->middleware('auth:sanctum');
    Route::put('/form', [CurrencyController::class, 'form'])->middleware('auth:sanctum');
    Route::delete('', [CurrencyController::class, 'delete'])->middleware('auth:sanctum');
});