<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MusiqueController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\FactureController;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/user/logout', [UserController::class, 'logout']);

    Route::get('/playlists', [PlaylistController::class, 'index']);
    Route::post('/playlists', [PlaylistController::class, 'store']);
    Route::post('playlists/{playlist}/musiques', [PlaylistController::class, 'addMusique']);

    Route::get('/factures', [FactureController::class, 'index']);
    Route::post('/factures', [FactureController::class, 'store']);
    Route::get('/factures/{id}', [FactureController::class, 'show']);
});

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::post('/register', [UserController::class, 'register']);

Route::get('/musiques', [MusiqueController::class, 'index']);
Route::get('/musiques/{id}', [MusiqueController::class, 'show']);

Route::get('/albums', [AlbumController::class, 'index']);
Route::get('/albums/{id}', [AlbumController::class, 'show']);

Route::get('/artistes/{id}', [ArtisteController::class, 'show']);