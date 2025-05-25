<?php

use App\Http\Controllers\Patient\PatientController;
use Illuminate\Support\Facades\Route;

//patient route
// name route patient.index
//url /patient

Route::get('/', [PatientController::class, 'index'])->name('index');
Route::get('/create', [PatientController::class, 'create'])->name('create');
Route::post('/store', [PatientController::class, 'store'])->name('store');
Route::get('/edit/{patient_id}', [PatientController::class, 'edit'])->name('edit');
Route::get('/view/{patient_id}', [PatientController::class, 'view'])->name('view');
