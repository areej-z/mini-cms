<?php

use Illuminate\Support\Facades\Route;

// Route d'accueil par défaut
Route::get('/', function () {
    return view('welcome');
});

// Route avec paramètre et nom (Étape 1)
Route::get('/salut/{prenom}', function ($prenom) {
    return "Bonjour $prenom ! Bienvenue dans Mini-CMS.";
})->name('salut');

// Route avec contrainte numérique (Étape 1)
Route::get('/articles/{id}', function ($id) {
    return "Affichage de l'article numéro : $id";
})->whereNumber('id')->name('articles.show');

// Route heure (conservée / adaptée)
Route::get('/heure', function () {
    return view('heure');
});

// Route à propos (avec vos données)
Route::get('/a-propos', function () {
    return view('a-propos', [
        'auteur' => 'Arij Znagui',
        'groupe' => 'MDW32',
    ]);
});

// Groupe de routes avec préfixe et nom (Étape 2)
Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return "Tableau de bord administrateur";
    })->name('dashboard');

    Route::get('/users', function () {
        return "Liste des utilisateurs";
    })->name('users.index');

});