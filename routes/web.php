<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('pessoas.index');
});

// Rotas públicas (visualização)
Route::get('/pessoas', [PessoaController::class, 'index'])->name('pessoas.index');
Route::get('/dashboard-paises', [DashboardController::class, 'index'])->name('dashboard.paises');

// Rotas protegidas (autenticação necessária)
Route::middleware('auth')->group(function () {
    Route::get('/pessoas/create', [PessoaController::class, 'create'])->name('pessoas.create');
    Route::post('/pessoas', [PessoaController::class, 'store'])->name('pessoas.store');
    
    Route::get('/contatos/create', [ContatoController::class, 'create'])->name('contatos.create');
    Route::post('/contatos', [ContatoController::class, 'store'])->name('contatos.store');
    
    Route::get('/pessoas/{id}/edit', [PessoaController::class, 'edit'])->name('pessoas.edit');
    Route::put('/pessoas/{id}', [PessoaController::class, 'update'])->name('pessoas.update');
    Route::delete('/pessoas/{id}', [PessoaController::class, 'destroy'])->name('pessoas.destroy');
    
    Route::get('/contatos/{id}/edit', [ContatoController::class, 'edit'])->name('contatos.edit');
    Route::put('/contatos/{id}', [ContatoController::class, 'update'])->name('contatos.update');
    Route::delete('/contatos/{id}', [ContatoController::class, 'destroy'])->name('contatos.destroy');
});

// Rotas com parâmetros (devem vir por último)
Route::get('/pessoas/{id}', [PessoaController::class, 'show'])->name('pessoas.show');
Route::get('/contatos/{id}', [ContatoController::class, 'show'])->name('contatos.show');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
