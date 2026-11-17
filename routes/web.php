<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\CoordinadorController;

//mostrar pantalla de inicio
Route::get('/inicio', function () {
    return view('Prueba_Pantalla_Inicial');
})->name('inicio');

// Mostrar el formulario de solicitud
Route::get('/', [FormularioController::class, 'create'])->name('Formulario.create');
// Recibir y procesar los datos del formulario
Route::post('/solicitar-seguro', [FormularioController::class, 'store'])->name('Formulario.store');

//rutas del coordinador
Route::get('/coordinador', [CoordinadorController::class, 'index'])->name('coordinador.dashboard');
Route::get('/coordinador/revisar/{id}', [CoordinadorController::class, 'show'])->name('coordinador.revisar');
Route::post('/coordinador/confirmar/{id}', [CoordinadorController::class, 'confirmar'])->name('coordinador.confirmar');
