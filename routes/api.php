<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Musique;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/musiques', function () {
    return Musique::with(['artistes', 'styles'])->get();
});