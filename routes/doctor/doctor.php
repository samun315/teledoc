<?php

use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\DoctorDepartmentController;
use Illuminate\Support\Facades\Route;

// doctor department
// name route  doctor.department.index
// url /doctor/department
Route::group(['prefix' => 'department', 'as' => 'department.'], function () {
    Route::get('/', [DoctorDepartmentController::class, 'index'])->name('index');
    Route::get('/create', [DoctorDepartmentController::class, 'create'])->name('create');
    Route::post('/store', [DoctorDepartmentController::class, 'store'])->name('store');
    Route::get('/edit/{department_id}', [DoctorDepartmentController::class, 'edit'])->name('edit');
    Route::put('/update/{department_id}', [DoctorDepartmentController::class, 'update'])->name('update');
});


// doctor 
// name route  doctor.index
// url /doctor
Route::get('/', [DoctorController::class, 'index'])->name('index');
Route::get('/create', [DoctorController::class, 'create'])->name('create');
Route::post('/store', [DoctorController::class, 'store'])->name('store');
Route::get('/edit/{patient_id}', [DoctorController::class, 'edit'])->name('edit');
Route::put('/update/{patient_id}', [DoctorController::class, 'update'])->name('update');
Route::get('/view/{patient_id}', [DoctorController::class, 'view'])->name('view');
