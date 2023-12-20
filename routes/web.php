<?php

use App\Http\Controllers\PagosController;
use App\Http\Controllers\TercerosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


/////////////////////////////////////////////////////////////////TERCEROS//////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/terceros', [TercerosController::class, 'index'])
    ->name('terceros.index');

Route::get('/terceros/create', [TercerosController::class, 'create'])
    ->name('terceros.create');

Route::post('/terceros', [TercerosController::class, 'store'])
    ->name('terceros.store');

Route::get('/terceros/{id}', [TercerosController::class, 'show'])
    ->name('terceros.show');

Route::get('/terceros/edit/{id}', [TercerosController::class, 'edit'])
    ->name('terceros.edit');

Route::put('/terceros/{id}', [TercerosController::class, 'update'])
    ->name('terceros.update');

Route::get('/terceros/fechaejecutiva/{id}', [TercerosController::class, 'fechaejecutiva'])
    ->name('terceros.fechaejecutiva');

Route::put('/terceros/ejecutiva/{id}', [TercerosController::class, 'ejecutiva'])
    ->name('terceros.ejecutiva');

Route::put('/terceros/noejecutiva/{id}', [TercerosController::class, 'noejecutiva'])
    ->name('terceros.noejecutiva');

Route::get('/terceros/fechaanular/{id}', [TercerosController::class, 'fechaanular'])
    ->name('terceros.fechaanular');

 Route::put('/terceros/anular/{id}', [TercerosController::class, 'anular'])
    ->name('terceros.anular');

Route::put('/terceros/reactivar/{id}', [TercerosController::class, 'reactivar'])
    ->name('terceros.reactivar');

/////////////////////////////////////////////////////////////////PAGOS//////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/pagos/create/{IdRd}', [PagosController::class, 'create'])
    ->name('pagos.create');

Route::post('/pagos', [PagosController::class, 'store'])
    ->name('pagos.store');

Route::get('/pagos/{id}', [PagosController::class, 'show'])
    ->name('pagos.show');

Route::get('/pagos/edit/{id}', [PagosController::class, 'edit'])
    ->name('pagos.edit');

Route::put('/pagos/{id}', [PagosController::class, 'update'])
    ->name('pagos.update');

Route::delete('/pagos/delete/{id}', [PagosController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
