<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\AdminController;

//auth - admin
/* Route::view('admin/', 'admin/dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('admin/profile', 'admin/profile')->middleware(['auth'])->name('profile');
Route::view('admin/convenios', 'admin.gestion-convenios')->middleware(['auth'])->name('convenios');

 */

Route::prefix('admin')->middleware(['auth', 'verified'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/convenios', [AdminController::class, 'convenios'])->name('convenios');
    Route::get('/contenido', [AdminController::class, 'cms'])->name('cms');
});

Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

require __DIR__ . '/auth.php';

//public
/* Route::view('/', 'site/convenios/welcome');
 */
Route::view('/nuestros-convenios', 'site/convenios/tabs/nuestros-convenios');

Route::redirect('/', '/inicio');
Route::get('/inicio', [SiteController::class, 'inicio']);
/* Route::redirect('/nosotros', '/inicio?tab=nosotros');
Route::redirect('/nuestros-convenios', '/inicio?tab=nuestros-convenios'); */
