<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);

Route::post('/users/{user}/send-welcome', [UserController::class, 'sendWelcomeEmail']);