<?php

use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Type\Time;
use App\Models\TipoConvenio;

use function Pest\Laravel\delete;

//auth - admin
Route::view('admin/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('admin/profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';

//public
Route::view('/', 'welcome');
Route::get('prueba', function () {
    $tipoConvenio = new TipoConvenio;

    /* $tipoConvenio->nombre = 'Prueba 1';
    $tipoConvenio->descripcion = 'Descripción de prueba 1';
    $tipoConvenio->save();
 */

/*     $tipoConvenio = TipoConvenio::find(3);
    $tipoConvenio -> delete();
 */
    $tipoConvenio = TipoConvenio::all();
    return $tipoConvenio;
});
