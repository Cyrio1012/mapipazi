<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DescentesController;
use App\Http\Controllers\FtController;

Route::resource('descentes', DescentesController::class);
Route::get('/', [DescentesController::class, 'dashboard'])->name('dashboard');

Route::resource('fts', FtController::class);
// Route::get('descentes/{descente}/create-ft', [FtController::class, 'createFromDescente'])->name('fts.create.from.descente');
Route::get('/descentes/{descente}/fts/create', [FtController::class, 'createFromDescente'])->name('fts.create.from.descente');

Route::get('/fts/{id}/export-pdf', [FtController::class, 'exportPdf'])->name('fts.export.pdf');