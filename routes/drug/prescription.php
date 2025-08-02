<?php

use App\Http\Controllers\Drug\DrugAdviceController;
use App\Http\Controllers\Drug\DrugController;
use App\Http\Controllers\Drug\DrugDosesController;
use App\Http\Controllers\Drug\DrugDurationController;
use App\Http\Controllers\Drug\DrugStrengthController;
use App\Http\Controllers\Drug\PrescriptionController;
use App\Http\Controllers\Drug\SubscriptionTypeController;
use Illuminate\Support\Facades\Route;

// prescription 
// name route  drug.prescription.index
// url /drug/prescription
Route::group(['prefix' => 'prescription'], function () {
    Route::get('/', [PrescriptionController::class, 'index'])->name('index');
    Route::get('/create/{patient_id}', [PrescriptionController::class, 'create'])->name('create');
    Route::post('/store', [PrescriptionController::class,  'store'])->name('store');
    Route::get('/get-patient', [PrescriptionController::class,  'getPatientList'])->name('getPatientList');
    Route::get('/edit/{menu_id}', [PrescriptionController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [PrescriptionController::class,  'update'])->name('update');

});
