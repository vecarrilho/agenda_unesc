<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('agenda', AgendaController::class);


Route::get('/', [AgendaController::class, 'index']);
Route::get('/insert_cadastro/{id_sala}', [AgendaController::class, 'insert_cadastro']);
Route::get('/search', [AgendaController::class, 'search']);
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');
