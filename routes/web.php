<?php
require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DescentesController;
use App\Http\Controllers\ProprieteController;
use App\Http\Controllers\FtController;
use App\Http\Controllers\ApController;
use App\Http\Controllers\CartographieController;
use App\Http\Controllers\DescenteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatroController;
use App\Models\Descentes;
use App\Http\Controllers\ArchivesController;
use App\Http\Controllers\guserController;
Route::middleware(['auth'])->group(function () {

    Route::resource('archives', ArchivesController::class);
    Route::resource('users', guserController::class);

    Route::resource('descentes', DescentesController::class);
    Route::get('/', [DescentesController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboardArchive', [ArchivesController::class, 'dashboard'])->name('dashboardArchive');
    
    Route::resource('fts', FtController::class);
    // Route::get('descentes/{descente}/create-ft', [FtController::class, 'createFromDescente'])->name('fts.create.from.descente');
    Route::get('/descentes/{descente}/fts/create', [FtController::class, 'createFromDescente'])->name('fts.create.from.descente');
    Route::get('/rdv', [DescentesController::class, 'rdv'])->name('descente.rdv');
    Route::post('/rdv/{id}', [DescentesController::class, 'comparution'])->name('descente.rdvmaj');
    
    Route::get('/fts/{id}/export-pdf', [FtController::class, 'exportPdf'])->name('fts.export.pdf');
    
    Route::get('/descentes/{descente}/proprietes/create', [ProprieteController::class, 'create'])->name('proprietes.create');
    Route::post('/proprietes', [ProprieteController::class, 'store'])->name('proprietes.store');
    
    Route::get('/descentes/{descente}/aps/create', [ApController::class, 'etablir_ap'])->name('aps.create');
    Route::post('/aps', [ApController::class, 'store'])->name('aps.store');
    Route::resource('aps', ApController::class);
    Route::get('/aps/{id}/export', [ApController::class, 'export'])->name('aps.export');
    
    Route::get('/cartographie', [CartographieController::class, 'index'])->name('cartographie.index');
    Route::resource('matros', MatroController::class);


});    


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

