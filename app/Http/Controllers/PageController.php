<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('a-propos');
    }

    public function time()
    {
        return view('heure', [
            'heure' => now()->format('H:i'),
            'date' => now()->format('d/m/Y'),
        ]);
    }
}