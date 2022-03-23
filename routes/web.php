<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;

Route::resource('agenda', AgendaController::class);

Route::get('/', [AgendaController::class, 'index']);
Route::get('/insert_cadastro/{id_sala}/{id_aluno}', [AgendaController::class, 'insert_cadastro'])->middleware('auth');
Route::get('/show_my_list/{id_aluno}', [AgendaController::class, 'show_my_list'])->middleware('auth');
Route::get('/search', [AgendaController::class, 'search'])->middleware('auth');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');
