<?php

use App\Http\Controllers\Blog\BlogCategoryController;
use App\Http\Controllers\Blog\BlogTagController;
use App\Http\Controllers\Blog\BlogController;
use Illuminate\Support\Facades\Route;

// blog category
// name route  blog.category.index
// url /blog/blog-category
Route::group(['prefix' => 'blog-category', 'as' => 'category.'], function () {
    Route::get('/', [BlogCategoryController::class, 'index'])->name('index');
    Route::post('/store', [BlogCategoryController::class, 'store'])->name('store');
    Route::get('/edit/{blog_category_id}', [BlogCategoryController::class, 'edit'])->name('edit');
    Route::put('/update/{blog_category_id}', [BlogCategoryController::class, 'update'])->name('update');
});

// blog tag
// name route  blog.tag.index
// url /blog/blog-tag
Route::group(['prefix' => 'blog-tag', 'as' => 'tag.'], function () {
    Route::get('/', [BlogTagController::class, 'index'])->name('index');
    Route::post('/store', [BlogTagController::class, 'store'])->name('store');
    Route::get('/edit/{blog_tag_id}', [BlogTagController::class, 'edit'])->name('edit');
    Route::put('/update/{blog_tag_id}', [BlogTagController::class, 'update'])->name('update');
});

// blog posts
// name route  blog.blog.index
// url /blog/blog
Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/create', [BlogController::class, 'create'])->name('create');
    Route::post('/store', [BlogController::class, 'store'])->name('store');
    Route::get('/edit/{blog_id}', [BlogController::class, 'edit'])->name('edit');
    Route::put('/update/{blog_id}', [BlogController::class, 'update'])->name('update');
    Route::delete('/delete/{blog_id}', [BlogController::class, 'destroy'])->name('delete');
});

