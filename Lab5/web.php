<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['course' => 'WIS']);
});

Route::get('/about', function () {
    return view('about');
});