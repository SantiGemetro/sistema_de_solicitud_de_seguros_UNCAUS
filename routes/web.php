<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\OperadorController;

// 1. Pantalla principal de inicio (Prueba_Pantalla_Inicial)
Route::get('/', function () {
    return view('Prueba_Pantalla_Inicial');
})->name('inicio');

Route::get('/inicio', function () {
    return redirect()->route('inicio');
});

// 2. Login unificado (Coordinadores y Operadores de Bienestar Estudiantil)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// 3. Rutas del formulario de solicitud de seguro
//por que estan duplicadas? xd
Route::get('/solicitar-seguro', [FormularioController::class, 'create'])->name('Formulario.create');
Route::get('/solicitud', [FormularioController::class, 'create'])->name('formulario.create');
Route::post('/solicitar-seguro', [FormularioController::class, 'store'])->name('Formulario.store');
Route::post('/solicitud', [FormularioController::class, 'store'])->name('formulario.store');

// 4. Rutas del Operador de Bienestar Estudiantil
Route::get('/operador/login', [AuthController::class, 'showLogin'])->name('operador.login');
Route::post('/operador/login', [AuthController::class, 'login'])->name('operador.login.post');
Route::post('/operador/logout', [OperadorController::class, 'logout'])->name('operador.logout');
Route::get('/operador/registrar', [OperadorController::class, 'registrar'])->name('operador.registrar');
Route::post('/operador/registrar', [OperadorController::class, 'store'])->name('operador.store');
Route::get('/operador', [OperadorController::class, 'index'])->name('operador.index');
Route::get('/operador/formulario/{id}', [OperadorController::class, 'show'])->name('operador.show');
Route::patch('/operador/formulario/{id}/estado', [OperadorController::class, 'actualizarEstado'])->name('operador.estado');
Route::get('/operador/formulario/{id}/pdf', [OperadorController::class, 'descargarPdf'])->name('operador.pdf');

// 5. Rutas de Registro de Nuevo Coordinador (dentro del rol de Operador de BE)
Route::get('/operador/coordinador/registrar', [CoordinadorController::class, 'registrar'])->name('coordinador.registrar');
Route::post('/operador/coordinador/registrar', [CoordinadorController::class, 'store'])->name('coordinador.store');

// 6. Rutas del Coordinador
Route::get('/coordinador/login', [AuthController::class, 'showLogin'])->name('coordinador.login');
Route::post('/coordinador/login', [AuthController::class, 'login'])->name('coordinador.login.post');
Route::post('/coordinador/logout', [CoordinadorController::class, 'logout'])->name('coordinador.logout');
Route::get('/coordinador', [CoordinadorController::class, 'index'])->name('coordinador.dashboard');
Route::get('/coordinador/revisar/{id}', [CoordinadorController::class, 'show'])->name('coordinador.revisar');
Route::post('/coordinador/confirmar/{id}', [CoordinadorController::class, 'confirmar'])->name('coordinador.confirmar');
