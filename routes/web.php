<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/musiques/{id}', function () {
    return view('musics.show');
});

Route::get('/albums/{id}', function () {
    return view('albums.show');
});

Route::get('/artistes/{id}', function () {
    return view('artists.show');
});