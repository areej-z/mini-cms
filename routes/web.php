<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route d'accueil via le PageController
Route::get('/', [PageController::class, 'home'])->name('home');

// Route à propos via le PageController
Route::get('/a-propos', [PageController::class, 'about'])->name('about');

// Route heure
Route::get('/heure', function () {
    return view('heure', [
        'heure' => now()->format('H:i'),
        'date' => now()->format('d/m/Y'),
    ]);
})->name('heure');

// Route avec paramètre et nom
Route::get('/salut/{prenom}', function ($prenom) {
    return "Bonjour $prenom ! Bienvenue dans Mini-CMS.";
})->name('salut');

// Route avec contrainte numérique
Route::get('/articles/{id}', function ($id) {
    return "Affichage de l'article numéro : $id";
})->whereNumber('id')->name('articles.show');

// Groupe de routes d'administration avec préfixe et nom
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return "Tableau de bord administrateur";
    })->name('dashboard');

    Route::get('/users', function () {
        return "Liste des utilisateurs";
    })->name('users.index');

});

// Routes pour les articles (index, archive et show)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/archive/{year}', [PostController::class, 'archive'])
    ->whereNumber('year')
    ->name('posts.archive');
Route::get('/posts/{slug}', [PostController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('posts.show');