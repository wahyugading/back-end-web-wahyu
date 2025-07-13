<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('welcome'); // Pastikan 'welcome' adalah file view utama Anda
})->where('any', '^(?!api\/).*$');
