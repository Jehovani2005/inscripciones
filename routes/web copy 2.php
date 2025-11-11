<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipanteController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\ParticipanteOfertaController;
use App\Http\Controllers\ValidacionController;
use App\Http\Controllers\OfertaDisciplinaController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->rol === 'Administrador') {
        return view('validaciones');
    }
    if (Auth::check() && Auth::user()->rol === 'Participante') {
        return view('participantes.create');
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
        return view('participantes.create');
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


    Route::get('/registro_participante', [ParticipanteController::class, 'create'])->name('participantes.create');
    Route::post('/participantes', [ParticipanteController::class, 'store'])->name('participantes.store');

    // Route::get('/registro', function () {
    //     return view('registro');
    // });

    // Route::get('/disciplinas', function () {
    //     return view('disciplinas');
    // });

    // Route::get('/documentos', function () {
    //     return view('documentos');
    // });

    // Route::get('/validaciones', function () {
    //     return view('validaciones');
    // });

    Route::get('/reportes', function () {
        return view('reportes');
    });

    Route::get('/configuracion', function () {
        return view('configuracion');
    });

    Route::get('/disciplinas', [DisciplinaController::class, 'index'])->name('disciplinas.index');
    Route::post('/disciplinas/seleccionar', [DisciplinaController::class, 'seleccionar'])->name('disciplinas.seleccionar');
    Route::post('/disciplinas/deseleccionar', [DisciplinaController::class, 'deseleccionar'])->name('disciplinas.deseleccionar');

    Route::post('/disciplinas/seleccionar', [ParticipanteOfertaController::class, 'seleccionar'])->name('disciplinas.seleccionar');
    Route::post('/disciplinas/eliminar', [ParticipanteOfertaController::class, 'eliminar'])->name('disciplinas.eliminar');


    Route::get('/validaciones', [ValidacionController::class, 'index'])->name('validaciones.index');
    Route::get('/validaciones/documentos/{id}', [ValidacionController::class, 'documentos'])->name('validaciones.documentos');
    Route::post('/validaciones/aprobar/{id}', [ValidacionController::class, 'aprobar'])->name('validaciones.aprobar');
    Route::post('/validaciones/rechazar/{id}', [ValidacionController::class, 'rechazar'])->name('validaciones.rechazar');

    Route::get('/ofertas', [OfertaDisciplinaController::class, 'index'])->name('ofertas.index');
    Route::put('/ofertas/{id}', [OfertaDisciplinaController::class, 'update'])->name('ofertas.update');
    Route::delete('/ofertas/{id}', [OfertaDisciplinaController::class, 'destroy'])->name('ofertas.destroy');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

    // Generar reportes en Excel
    Route::get('/reportes/inscritos-disciplina', [ReporteController::class, 'reportePorDisciplina'])->name('reportes.porDisciplina');
    Route::get('/reportes/consolidado', [ReporteController::class, 'reporteConsolidado'])->name('reportes.consolidado');

});

require __DIR__.'/auth.php';
