<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegistrationController::class, 'registration']);

Route::post('/logout', [LogoutController::class, 'logout']
)->middleware('auth:sanctum');;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
