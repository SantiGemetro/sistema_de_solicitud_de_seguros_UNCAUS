<?php

use App\Http\Controllers\FormularioController;
use App\Http\Controllers\OperadorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('operador.index');
});

// Rutas de carga de solicitud
Route::get('/solicitud', [FormularioController::class, 'create'])->name('formulario.create');
Route::post('/solicitud', [FormularioController::class, 'store'])->name('formulario.store');

// Rutas del Operador de Bienestar Estudiantil
Route::get('/operador', [OperadorController::class, 'index'])->name('operador.index');
Route::get('/operador/formulario/{id}', [OperadorController::class, 'show'])->name('operador.show');
Route::patch('/operador/formulario/{id}/estado', [OperadorController::class, 'actualizarEstado'])->name('operador.estado');