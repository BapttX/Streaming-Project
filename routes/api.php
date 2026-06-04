<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MusiqueController;
use App\Http\Controllers\AlbumController;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/user/logout', [UserController::class, 'logout']);
});

Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

Route::get('/musiques', [MusiqueController::class, 'index']);

Route::get('/albums', [AlbumController::class, 'index']);