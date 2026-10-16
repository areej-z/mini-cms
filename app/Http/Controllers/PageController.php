<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('welcome'); // ou la vue d'accueil de votre choix
    }

    public function about()
    {
        return view('a-propos', [
            'auteur' => 'Arij Znagui',
            'groupe' => 'MDW32',
        ]);
    }
}