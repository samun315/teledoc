<?php

use App\Http\Controllers\Doctor\DoctorAppointmentController;
use Illuminate\Support\Facades\Route;

// appointment
// name route  appointment.index
// url /appointment
    Route::get('/', [DoctorAppointmentController::class, 'index'])->name('index');
    Route::get('/create', [DoctorAppointmentController::class, 'create'])->name('create');
    Route::get('/get-doctor-info/{doctor_id}', [DoctorAppointmentController::class, 'getDoctorInfoById'])->name('getDoctorInfoById');
    Route::get('/get-patient-info/{patient_id}', [DoctorAppointmentController::class, 'getPatientInfoById']);
    Route::post('/store', [DoctorAppointmentController::class, 'store'])->name('store');
    Route::get('/edit/{doctor_id}', [DoctorAppointmentController::class, 'edit'])->name('edit');
    Route::put('/update', [DoctorAppointmentController::class, 'update'])->name('update');
