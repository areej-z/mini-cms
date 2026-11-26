<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::middleware('guest')->group(function () {
    Route::get('/inscription', [RegisterController::class, 'create'])->name('register');
    Route::post('/inscription', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/connexion', [LoginController::class, 'create'])->name('login');
    Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/deconnexion', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('writable')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/mes-articles', [PostController::class, 'myPosts'])->name('my-posts');
        Route::resource('posts', PostController::class)->except(['index', 'show']);
        Route::patch('/posts/{post}/publication', [PostController::class, 'togglePublication'])->name('posts.publication');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('categories', CategoryController::class)->except('show');
            Route::resource('tags', TagController::class)->except('show');
        });
    });

    Route::resource('posts', PostController::class)->only(['index', 'show']);
});