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
    Route::get('/edit/{prescription_id}', [PrescriptionController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [PrescriptionController::class,  'update'])->name('update');
    Route::get('/get-drug-dose/{drug_type_id}', [PrescriptionController::class,  'getDrugDoseByType'])->name('getDrugDoseByType');


    Route::get('/get-subscriptions/{subscription_type_id}', [PrescriptionController::class,  'getSubscriptionList'])->name('getSubscriptionList');
    Route::post('/create-subscription/{subscription_type_id}', [PrescriptionController::class,  'createSubscription'])->name('createSubscription');

<<<<<<< HEAD
     Route::get('/get-doctor-prescriptions/{doctor_id}/{patient_id}', [PrescriptionController::class,  'getDoctorPrescriptionList'])->name('getDoctorPrescriptionList');
     Route::get('/get-old-prescriptions/{prescription_id}', [PrescriptionController::class,  'getOldPrescriptionList'])->name('getOldPrescriptionList');

    // Prescription Preview Route
    Route::get('/preview', function () {
        return view('drug.preview');
    })->name('preview');
     Route::get('/prescriptions/print/{prescription_id}', [PrescriptionController::class, 'printPrescription'])->name('print');
=======
    Route::get('/get-doctor-prescriptions/{doctor_id}/{patient_id}', [PrescriptionController::class,  'getDoctorPrescriptionList'])->name('getDoctorPrescriptionList');
    Route::get('/get-old-prescriptions/{prescription_id}', [PrescriptionController::class,  'getOldPrescriptionList'])->name('getOldPrescriptionList');
>>>>>>> e7cbd17e76ebb4f7a012f70d490b1ec20857c701

    Route::get('/prescriptions/print/{prescription_id}', [PrescriptionController::class, 'printPrescription'])->name('print');
});
