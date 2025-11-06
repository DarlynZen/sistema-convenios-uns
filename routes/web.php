<?php

use Illuminate\Support\Facades\Route;

//public
Route::view('/', 'welcome');

//auth - admin
Route::view('admin/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('admin/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
