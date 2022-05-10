<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AdminController;


Route::resource('agenda', AgendaController::class)->middleware('auth');
Route::resource('admin', AdminController::class)->middleware('auth');

Route::get('/', [AgendaController::class, 'index']);
Route::get('/dashboard', [AgendaController::class, 'index']);

Route::get('/search', [AgendaController::class, 'search'])
    ->middleware('auth');

Route::get('/showMyList/{id_aluno}', [AgendaController::class, 'showMyList'])
    ->name('agenda.myList')
    ->middleware('auth');

Route::get('/admin/create/polo', [AdminController::class, 'createPolo'])
    ->middleware('auth')
    ->name('admin.createPolo');

Route::get('/admin/create/export', [AdminController::class, 'createExport'])
    ->middleware('auth')
    ->name('admin.createExport');

Route::post('/admin/store/polo', [AdminController::class, 'storePolo'])
    ->middleware('auth')
    ->name('admin.storePolo');

Route::get('/admin/create/sala', [AdminController::class, 'createSala'])
    ->middleware('auth')
    ->name('admin.createSala');

Route::post('/admin/store/sala', [AdminController::class, 'storeSala'])
    ->middleware('auth')
    ->name('admin.storeSala');

Route::get('/export', [AdminController::class, 'export'])
    ->middleware('auth')
    ->name('admin.export');

Route::get('/agenda/getAluno', [AgendaController::class, 'getAluno'])
    ->middleware('auth')
    ->name('getAluno.get');

//rota ao logar
Route::middleware(['auth:sanctum', 'verified'])->get('/', [AgendaController::class, 'index']);
