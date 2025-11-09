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
    Route::get('/edit/{appointment_id}', [DoctorAppointmentController::class, 'edit'])->name('edit');
    Route::put('/update/{appointment_id}', [DoctorAppointmentController::class, 'update'])->name('update');
    Route::get('/generate-daily-slots/{doctor_id}/{date}',[DoctorAppointmentController::class,'generateDailySlots']);
    Route::get('/get-previous-slot/{doctor_id}/{date}/{appointment_id}',[DoctorAppointmentController::class,'getPreviousSlot']);