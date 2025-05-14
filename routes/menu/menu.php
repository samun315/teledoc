<?php

use App\Http\Controllers\Menu\Menu\MenuController;
use App\Http\Controllers\Menu\Menu\MenuItemController;
use Illuminate\Support\Facades\Route;


//Menu  //menu.menu.index
Route::group(['prefix' => 'menu', 'as' => 'menu.'], function () {
    Route::get('/', [MenuController::class, 'index'])->name('index');
    Route::post('/store', [MenuController::class,  'store'])->name('store');
    Route::get('/edit/{menu_id}', [MenuController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [MenuController::class,  'update'])->name('update');
});

Route::group(['prefix' => 'menu-item', 'as' => 'menu.menuItem.'], function () {
    Route::get('/{menu_id}', [MenuItemController::class, 'index'])->name('index');
    Route::get('/module-item/{module_id}', [MenuItemController::class, 'moduleItem'])->name('moduleItem');
    Route::get('/get-parent-id/{module_id}', [MenuItemController::class, 'getParent'])->name('getParent');
    Route::post('/store', [MenuItemController::class, 'store'])->name('store');
    Route::get('/menu-item/{menu_id}', [MenuItemController::class, 'menuItemList'])->name('menuItemList');
    Route::get('/edit/{menu_item_id}', [MenuItemController::class, 'edit'])->name('edit');
    Route::put('/update/{menu_item_id}', [MenuItemController::class,  'update'])->name('update');
    Route::post('/order/{menu_item_id}', [MenuItemController::class, 'order'])->name('order');
    Route::delete('/destroy/{menu_item_id}', [MenuItemController::class, 'destroy'])->name('destroy');
});
