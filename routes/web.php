<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Type\Time;

//auth - admin
Route::view('admin/', 'admin/dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('admin/profile', 'admin/profile')->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';

//public
/* Route::view('/', 'site/convenios/welcome');
 */Route::view('/nuestros-convenios', 'site/convenios/tabs/nuestros-convenios');

Route::redirect('/', '/inicio');
Route::get('/inicio', [SiteController::class, 'inicio']);
/* Route::redirect('/nosotros', '/inicio?tab=nosotros');
Route::redirect('/nuestros-convenios', '/inicio?tab=nuestros-convenios'); */
