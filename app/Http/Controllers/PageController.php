<?php

namespace App\Http\Controllers;

use Illuminate\View\View; // <-- Vérifiez que c'est bien cette ligne exacte

class PageController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function about(): View
    {
        return view('a-propos', [
            'auteur' => 'Arij Znagui',
            'groupe' => 'MDW32',
        ]);
    }

    public function time(): View
    {
        return view('heure', [
            'heure' => now()->format('H:i'),
            'date' => now()->format('d/m/Y'),
        ]);
    }
}