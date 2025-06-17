<?php

use App\Http\Controllers\Doctor\DoctorDepartmentController;
use Illuminate\Support\Facades\Route;

// doctor 
// name route  doctor.department.index
// url /doctor/department
Route::group(['prefix' => 'department', 'as' => 'department.'], function () {
    Route::get('/', [DoctorDepartmentController::class, 'index'])->name('index');
    Route::get('/create', [DoctorDepartmentController::class, 'create'])->name('create');
    Route::post('/store', [DoctorDepartmentController::class, 'store'])->name('store');
    Route::get('/edit/{department_id}', [DoctorDepartmentController::class, 'edit'])->name('edit');
    Route::put('/update/{department_id}', [DoctorDepartmentController::class, 'update'])->name('update');
});
