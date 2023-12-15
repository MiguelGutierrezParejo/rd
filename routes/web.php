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
Route::delete('/terceros/delete/{id}', [TercerosController::class, 'destroy']);


Route::get('/pagos', [PagosController::class, 'index'])
    ->name('pagos.index');
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
