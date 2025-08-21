#!/bin/bash

# Añadir imports de controladores PA
imports_section="
use App\Http\Controllers\Empresa\DpmrPaController;
use App\Http\Controllers\Empresa\AdpmrPaController;
use App\Http\Controllers\Empresa\AmpmrPaController;
use App\Http\Controllers\Empresa\MpmrPaController;
use App\Http\Controllers\Empresa\EcPaController;
use App\Http\Controllers\Empresa\NtrrPaController;
use App\Http\Controllers\Empresa\NulidadPaController;
use App\Http\Controllers\Empresa\OcursoPaController;
use App\Http\Controllers\Empresa\ResolucionPaController;
use App\Http\Controllers\Empresa\RoPaController;
use App\Http\Controllers\Empresa\RrPaController;
use App\Http\Controllers\Empresa\RtributaPaController;"

# Añadir rutas PA
routes_section="
    // Rutas DPMR PA
    Route::post('insert-dpmr-pa', [DpmrPaController::class, 'insert'])->name('insert.dpmr.pa');
    Route::put('update-dpmr-pa/{id}', [DpmrPaController::class, 'update'])->name('update.dpmr.pa');
    Route::delete('delete-dpmr-pa/{id}', [DpmrPaController::class, 'destroy'])->name('delete.dpmr.pa');

    // Rutas ADPMR PA
    Route::post('insert-adpmr-pa', [AdpmrPaController::class, 'insert'])->name('insert.adpmr.pa');
    Route::put('update-adpmr-pa/{id}', [AdpmrPaController::class, 'update'])->name('update.adpmr.pa');
    Route::delete('delete-adpmr-pa/{id}', [AdpmrPaController::class, 'destroy'])->name('delete.adpmr.pa');

    // Rutas AMPMR PA
    Route::post('insert-ampmr-pa', [AmpmrPaController::class, 'insert'])->name('insert.ampmr.pa');
    Route::put('update-ampmr-pa/{id}', [AmpmrPaController::class, 'update'])->name('update.ampmr.pa');
    Route::delete('delete-ampmr-pa/{id}', [AmpmrPaController::class, 'destroy'])->name('delete.ampmr.pa');

    // Rutas MPMR PA
    Route::post('insert-mpmr-pa', [MpmrPaController::class, 'insert'])->name('insert.mpmr.pa');
    Route::put('update-mpmr-pa/{id}', [MpmrPaController::class, 'update'])->name('update.mpmr.pa');
    Route::delete('delete-mpmr-pa/{id}', [MpmrPaController::class, 'destroy'])->name('delete.mpmr.pa');

    // Rutas EC PA
    Route::post('insert-ec-pa', [EcPaController::class, 'insert'])->name('insert.ec.pa');
    Route::put('update-ec-pa/{id}', [EcPaController::class, 'update'])->name('update.ec.pa');
    Route::delete('delete-ec-pa/{id}', [EcPaController::class, 'destroy'])->name('delete.ec.pa');

    // Rutas NTRR PA
    Route::post('insert-ntrr-pa', [NtrrPaController::class, 'insert'])->name('insert.ntrr.pa');
    Route::put('update-ntrr-pa/{id}', [NtrrPaController::class, 'update'])->name('update.ntrr.pa');
    Route::delete('delete-ntrr-pa/{id}', [NtrrPaController::class, 'destroy'])->name('delete.ntrr.pa');

    // Rutas Nulidad PA
    Route::post('insert-nulidad-pa', [NulidadPaController::class, 'insert'])->name('insert.nulidad.pa');
    Route::put('update-nulidad-pa/{id}', [NulidadPaController::class, 'update'])->name('update.nulidad.pa');
    Route::delete('delete-nulidad-pa/{id}', [NulidadPaController::class, 'destroy'])->name('delete.nulidad.pa');

    // Rutas Ocurso PA
    Route::post('insert-ocurso-pa', [OcursoPaController::class, 'insert'])->name('insert.ocurso.pa');
    Route::put('update-ocurso-pa/{id}', [OcursoPaController::class, 'update'])->name('update.ocurso.pa');
    Route::delete('delete-ocurso-pa/{id}', [OcursoPaController::class, 'destroy'])->name('delete.ocurso.pa');

    // Rutas Resolución PA
    Route::post('insert-resolucion-pa', [ResolucionPaController::class, 'insert'])->name('insert.resolucion.pa');
    Route::put('update-resolucion-pa/{id}', [ResolucionPaController::class, 'update'])->name('update.resolucion.pa');
    Route::delete('delete-resolucion-pa/{id}', [ResolucionPaController::class, 'destroy'])->name('delete.resolucion.pa');

    // Rutas RO PA
    Route::post('insert-ro-pa', [RoPaController::class, 'insert'])->name('insert.ro.pa');
    Route::put('update-ro-pa/{id}', [RoPaController::class, 'update'])->name('update.ro.pa');
    Route::delete('delete-ro-pa/{id}', [RoPaController::class, 'destroy'])->name('delete.ro.pa');

    // Rutas RR PA
    Route::post('insert-rr-pa', [RrPaController::class, 'insert'])->name('insert.rr.pa');
    Route::put('update-rr-pa/{id}', [RrPaController::class, 'update'])->name('update.rr.pa');
    Route::delete('delete-rr-pa/{id}', [RrPaController::class, 'destroy'])->name('delete.rr.pa');

    // Rutas Rtributa PA
    Route::post('insert-rtributa-pa', [RtributaPaController::class, 'insert'])->name('insert.rtributa.pa');
    Route::put('update-rtributa-pa/{id}', [RtributaPaController::class, 'update'])->name('update.rtributa.pa');
    Route::delete('delete-rtributa-pa/{id}', [RtributaPaController::class, 'destroy'])->name('delete.rtributa.pa');"

echo "Script listo para añadir rutas PA"
