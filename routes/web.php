<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;

// Mostrar el formulario de solicitud
Route::get('/', [FormularioController::class, 'create']);

// Recibir y procesar los datos del formulario
Route::post('/solicitar-seguro', [FormularioController::class, 'store'])->name('Formulario.store');
