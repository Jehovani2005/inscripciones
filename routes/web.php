<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

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