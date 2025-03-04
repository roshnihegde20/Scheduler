<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/test', function () { return response()->json(['message' => 'API is working']); });
Route::get('/users', [UserController::class, 'index']);
