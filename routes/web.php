<?php

use App\Http\Controllers\RusiaController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\TransaccionController;
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

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [RusiaController::class, 'loginView'])->name('login.view');
    Route::post('/login', [RusiaController::class, 'login'])->name('login');
});



Route::middleware(['auth:web'])->group(function () {
    Route::post('/logout', [RusiaController::class, 'logout'])->name('logout');


    Route::get('/', [RusiaController::class, 'menu'])->name('menu');
    Route::post('/transaccion', [RusiaController::class, 'insertar'])->name('transaccion.insertar');

    Route::get('/tipos', [TipoController::class, 'indexWeb'])->name('tipos.index');
    Route::delete('/tipos/{tipo}', [TipoController::class, 'destroyWeb'])->name('tipos.destroy');

    Route::get('/reportes', [RusiaController::class, 'reportes'])->name('reportes');


    Route::get('/transacciones', [TransaccionController::class, 'indexWeb'])->name('transacciones.index');
    Route::delete('/transacciones/{transaccion}', [TransaccionController::class, 'destroyWeb'])->name('transacciones.destroy');

});
