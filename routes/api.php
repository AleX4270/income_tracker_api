<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::prefix('auth')->group(function() {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/email/verify/{id}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    Route::get('/email/resend', [AuthController::class, 'resendEmail'])->name('verification.resend');
});