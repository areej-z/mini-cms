<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/heure', [PageController::class, 'time'])->name('time');

Route::get('/posts/archive/{year}', [PostController::class, 'archive'])
    ->whereNumber('year')
    ->name('posts.archive');
Route::get('/posts/categorie/{category:slug}', [PostController::class, 'byCategory'])->name('posts.category');
Route::get('/posts/tag/{tag:slug}', [PostController::class, 'byTag'])->name('posts.tag');

Route::middleware('writable')->group(function () {
    Route::resource('posts', PostController::class);
    Route::patch('/posts/{post}/publication', [PostController::class, 'togglePublication'])->name('posts.publication');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('tags', TagController::class)->except('show');
    });
});