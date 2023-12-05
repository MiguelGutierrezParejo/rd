<?php

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
    ->name('terceros.creade');
Route::post('/terceros', [TercerosController::class, 'store'])
    ->name('terceros.store');
Route::get('/terceros/{id}', [TercerosController::class, 'show'])
    ->name('terceros.show');
Route::get('/terceros/edit/{id}', [TercerosController::class, 'edit'])
    ->name('terceros.edit');
Route::put('/terceros/{id}', [TercerosController::class, 'update'])
    ->name('terceros.update');
Route::delete('/terceros/delete/{id}', [TercerosController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
