<?php

use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\DoctorScheduleController;
use Illuminate\Support\Facades\Route;

// doctor schedule
// name route  schedule.index
// url /schedule
    Route::get('/', [DoctorScheduleController::class, 'index'])->name('index');
    Route::get('/create', [DoctorScheduleController::class, 'create'])->name('create');
    Route::get('/get-doctor-info/{doctor_id}', [DoctorScheduleController::class, 'getDoctorInfoById'])->name('getDoctorInfoById');
    Route::post('/store', [DoctorScheduleController::class, 'store'])->name('store');
    Route::get('/edit/{doctor_id}', [DoctorScheduleController::class, 'edit'])->name('edit');
    Route::put('/update', [DoctorScheduleController::class, 'update'])->name('update');
