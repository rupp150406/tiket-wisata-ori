<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.todo.auth.login');
});

Route::get('/awal', function () {
    return view('welcome');
});




