<?php

use Illuminate\Support\Facades\Route;

Route::view('/admin/{any?}', 'admin')
    ->where('any', '.*')
    ->name('admin.spa');

Route::get('/', function () {
    return view('welcome');
});

