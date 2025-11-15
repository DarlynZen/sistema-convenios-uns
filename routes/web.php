<?php

use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Type\Time;
use App\Models\TipoConvenio;

//auth - admin
Route::view('admin/', 'admin/dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('admin/profile', 'admin/profile')->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';

//public
Route::view('/', 'site/convenios/welcome');
/* Route::view('/nuestros-convenios', 'site/convenios/tabs/nuestros-convenios');
 */