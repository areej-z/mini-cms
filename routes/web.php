<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route d'accueil via le PageController
Route::get('/', [PageController::class, 'home'])->name('home');

// Route à propos via le PageController
Route::get('/a-propos', [PageController::class, 'about'])->name('about');

// Route heure via le PageController
Route::get('/heure', [PageController::class, 'time'])->name('time');

// Route avec paramètre et nom (Étape 1)
Route::get('/salut/{prenom}', function ($prenom) {
    return "Bonjour $prenom ! Bienvenue dans Mini-CMS.";
})->name('salut');

// Route avec contrainte numérique (Étape 1)
Route::get('/articles/{id}', function ($id) {
    return "Affichage de l'article numéro : $id";
})->whereNumber('id')->name('articles.show');

// Groupe de routes d'administration avec préfixe et nom (Étape 2)
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return "Tableau de bord administrateur";
    })->name('dashboard');

    Route::get('/users', function () {
        return "Liste des utilisateurs";
    })->name('users.index');

});

// Groupe factorisé pour les routes des articles
Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');

    Route::get('/archive/{year}', [PostController::class, 'archive'])
        ->whereNumber('year')
        ->name('archive');

    Route::get('/{slug}', [PostController::class, 'show'])
        ->where('slug', '[a-z0-9-]+')
        ->name('show');
});