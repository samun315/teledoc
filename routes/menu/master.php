<?php

use App\Http\Controllers\Menu\Master\MenuModuleController;
use App\Http\Controllers\Menu\Master\PermissionController;
use App\Http\Controllers\Menu\Master\ModuleItemController;
use App\Http\Controllers\Menu\Master\RolePermissionController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'module', 'as' => 'module.'], function () {

    //Example route name => menu.master.module.index

    Route::get('/', [MenuModuleController::class, 'index'])->name('index');
    Route::get('/create', [MenuModuleController::class, 'create'])->name('create');
    Route::post('/store', [MenuModuleController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [MenuModuleController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [MenuModuleController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [MenuModuleController::class, 'delete'])->name('delete');
    Route::put('/update-status', [MenuModuleController::class, 'updateStatus'])->name('update.status');
});

// menu.master.module.permission route start
Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::get('/create', [PermissionController::class, 'create'])->name('create');
    Route::post('/store', [PermissionController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PermissionController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PermissionController::class, 'delete'])->name('delete');
    Route::put('/update-status', [PermissionController::class, 'updateStatus'])->name('update.status');
});

Route::group(['prefix' => 'module-item', 'as' => 'moduleItem.'], function () {
    //Example route name => menu.master.moduleItem.index
    Route::get('/', [ModuleItemController::class, 'index'])->name('index');
    Route::get('/create', [ModuleItemController::class, 'create'])->name('create');
    Route::post('/store', [ModuleItemController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ModuleItemController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ModuleItemController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ModuleItemController::class, 'delete'])->name('delete');
    Route::put('/update-status', [ModuleItemController::class, 'updateStatus'])->name('update.status');
});


Route::group(['prefix' => 'role-permission', 'as' => 'rolePermission.'], function () {
     //Example route name => menu.master.rolePermission.index
    Route::get('/', [RolePermissionController::class, 'index'])->name('index');
    Route::get('/create', [RolePermissionController::class, 'create'])->name('create');
    Route::post('/store', [RolePermissionController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [RolePermissionController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [RolePermissionController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RolePermissionController::class, 'delete'])->name('delete');
    Route::put('/update-status', [RolePermissionController::class, 'updateStatus'])->name('update.status');
});

