<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->rol === 'Administrador') {
        return view('validaciones');
    }
    if (Auth::check() && Auth::user()->rol === 'Participante') {
        return view('registro');
    }
    if (Auth::check() && Auth::user()->rol === 'Supervisor') {
        return view('reportes');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    if (Auth::check() && Auth::user()->rol === 'Administrador') {
        return view('validaciones');
    }
    if (Auth::check() && Auth::user()->rol === 'Participante') {
        return view('registro');
    }
    if (Auth::check() && Auth::user()->rol === 'Supervisor') {
        return view('reportes');
    }
    return redirect('/login'); // Muestra la página de inicio si no está autenticado
})->name('inicio');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/registro', function () {
        return view('registro');
    });

    Route::get('/disciplinas', function () {
        return view('disciplinas');
    });

    Route::get('/documentos', function () {
        return view('documentos');
    });

    Route::get('/validaciones', function () {
        return view('validaciones');
    });

    Route::get('/reportes', function () {
        return view('reportes');
    });

    Route::get('/configuracion', function () {
        return view('configuracion');
    });



});

require __DIR__.'/auth.php';
