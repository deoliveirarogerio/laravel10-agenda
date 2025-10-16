<?php

use Illuminate\Support\Facades\Route;

// Painel Admin (SPA) — deve vir ANTES de outras rotas que possam capturar /admin
Route::view('/admin/{any?}', 'admin')
    ->where('any', '.*')
    ->name('admin.spa');

Route::get('/', function () {
    return view('welcome');
});

