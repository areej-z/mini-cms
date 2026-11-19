<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');

Route::middleware('writable')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::match(['put', 'patch'], '/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::patch('/posts/{post}/toggle-publication', [PostController::class, 'togglePublication'])->name('posts.toggle-publication');
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/archive/{year}', [PostController::class, 'archive'])->name('posts.archive');
Route::get('/posts/category/{category:slug}', [PostController::class, 'byCategory'])->name('posts.category');
Route::get('/posts/tag/{tag:slug}', [PostController::class, 'byTag'])->name('posts.tag');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');