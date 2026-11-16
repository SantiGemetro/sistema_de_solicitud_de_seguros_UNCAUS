<?php

use App\Http\Controllers\FormularioController;
use App\Http\Controllers\OperadorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('operador.login');
});

// Rutas de carga de solicitud
Route::get('/solicitud', [FormularioController::class, 'create'])->name('formulario.create');
Route::post('/solicitud', [FormularioController::class, 'store'])->name('formulario.store');


// -------------Rutas del Operador de Bienestar Estudiantil-------------

// Rutas de Autenticación del Operador de Bienestar Estudiantil
Route::get('/operador/login', [OperadorController::class, 'showLogin'])->name('operador.login');
Route::post('/operador/login', [OperadorController::class, 'login'])->name('operador.login.post');
Route::post('/operador/logout', [OperadorController::class, 'logout'])->name('operador.logout');

// Rutas de Creación de Nuevos Operadores de BE
Route::get('/operador/crear', [OperadorController::class, 'registrar'])->name('operador.registrar');
Route::post('/operador/crear', [OperadorController::class, 'store'])->name('operador.store');

// Rutas del Panel del Operador de Bienestar Estudiantil
Route::get('/operador', [OperadorController::class, 'index'])->name('operador.index');
Route::get('/operador/formulario/{id}', [OperadorController::class, 'show'])->name('operador.show');
Route::patch('/operador/formulario/{id}/estado', [OperadorController::class, 'actualizarEstado'])->name('operador.estado');
