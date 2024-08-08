<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::post('/token/create', function(Request $request) {
//     $user = User::factory()->createOne();
//     $token = $user->createToken('token');

//     return [
//         'token' => $token->plainTextToken
//     ];
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
